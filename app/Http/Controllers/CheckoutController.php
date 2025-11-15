<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB; // <-- Rất quan trọng cho Transaction
use Illuminate\Support\Facades\Auth; // <-- Thêm nếu dùng auth()->id()

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang Checkout
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // Nếu giỏ hàng rỗng, đá về trang shop
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Giỏ hàng của bạn rỗng!');
        }
        
        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        return view('checkout.index', compact('cart', 'totalPrice'));
    }

    public function store(Request $request)
    {
        // 1. Validate thông tin khách hàng
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'user_id' => 'nullable|exists:users,id', // 'nullable' cho khách vãng lai
        ]);

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // 2. Kiểm tra giỏ hàng rỗng
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Giỏ hàng của bạn rỗng!');
        }
        
        // Tính tổng tiền
        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        // 3. Bắt đầu Database Transaction
        DB::beginTransaction();

        try {
            // === Bước A: Tạo Đơn hàng (Order) ===
            $order = Order::create([
                'user_id' => $request->user_id ?? null, // Lấy user_id nếu có
                'customer_name' => $validatedData['customer_name'],
                'customer_email' => $validatedData['customer_email'],
                'customer_phone' => $validatedData['customer_phone'],
                'shipping_address' => $validatedData['shipping_address'],
                'total_price' => $totalPrice,
                'status' => 'pending', // Mặc định là 'chờ xử lý'
            ]);

            // === Bước B: Tạo Chi tiết Đơn hàng (OrderItems) & Trừ Kho ===
            foreach ($cart as $productId => $details) {
                $product = Product::findOrFail($productId); // Lấy sản phẩm

                // Kiểm tra tồn kho lần cuối
                if ($product->stock_quantity < $details['quantity']) {
                    // Nếu hết hàng, HỦY BỎ transaction
                    throw new \Exception('Sản phẩm ' . $product->name . ' không đủ số lượng.');
                }

                // Tạo OrderItem
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'], // Lưu lại giá tại thời điểm mua
                ]);

                // Trừ số lượng tồn kho
                $product->stock_quantity -= $details['quantity'];
                $product->save();
            }

            // === Bước C: Thành công -> Commit Transaction ===
            DB::commit();

            // === Bước D: Xóa giỏ hàng ===
            session()->forget('cart');

            // Chuyển hướng đến trang Cảm ơn
            return redirect()->route('checkout.success')->with('order_id', $order->id);

        } catch (\Exception $e) {
            // === Bước E: Thất bại -> Rollback Transaction ===
            DB::rollBack();

            // Quay lại trang checkout với thông báo lỗi
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }

    public function success()
    {
        // Lấy order_id được gửi qua session từ hàm store()
        $orderId = session('order_id');

        // Nếu không có order_id (ví dụ: F5 lại trang), đá về shop
        if (!$orderId) {
            return redirect()->route('shop.index');
        }
        
        // Tìm đơn hàng để hiển thị mã đơn hàng
        $order = Order::findOrFail($orderId);

        return view('checkout.success', compact('order'));
    }
}