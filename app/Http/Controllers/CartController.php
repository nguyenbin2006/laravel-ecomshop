<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // <-- Thêm

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []); // Lấy giỏ hàng từ session

        $totalPrice = 0;
        // Tính tổng tiền
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        // Trả về view và truyền dữ liệu giỏ hàng, tổng tiền
        return view('cart.index', compact('cart', 'totalPrice'));
    }

    public function add(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        // 2. Tìm sản phẩm
        $product = Product::findOrFail($productId);

        // 3. Kiểm tra số lượng tồn kho
        if ($product->stock_quantity < $quantity) {
            return back()->with('error', 'Số lượng sản phẩm không đủ!');
        }

        // 4. Lấy giỏ hàng từ Session (nếu chưa có thì tạo mảng rỗng)
        $cart = session()->get('cart', []);

        // 5. Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$productId])) {
            // Nếu đã có -> cập nhật số lượng
            // (Kiểm tra lại tổng số lượng với tồn kho)
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($product->stock_quantity < $newQuantity) {
                 return back()->with('error', 'Số lượng sản phẩm trong giỏ vượt quá tồn kho!');
            }
            $cart[$productId]['quantity'] = $newQuantity;

        } else {
            // Nếu chưa có -> thêm mới vào giỏ
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // 6. Lưu giỏ hàng mới vào Session
        session()->put('cart', $cart);

        // 7. Quay lại trang trước với thông báo thành công
        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1', // Số lượng mới
        ]);

        $productId = $request->product_id;
        $newQuantity = $request->quantity;

        // Lấy giỏ hàng
        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm có tồn tại trong giỏ không
        if (isset($cart[$productId])) {
            // Kiểm tra tồn kho
            $product = Product::findOrFail($productId);
            if ($product->stock_quantity < $newQuantity) {
                return back()->with('error', 'Số lượng sản phẩm không đủ!');
            }

            // Cập nhật số lượng
            $cart[$productId]['quantity'] = $newQuantity;
            session()->put('cart', $cart);

            return back()->with('success', 'Đã cập nhật số lượng sản phẩm!');
        }

        return back()->with('error', 'Sản phẩm không tìm thấy trong giỏ hàng!');
    }

/**
 * Xóa sản phẩm khỏi giỏ hàng
 */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm có tồn tại trong giỏ không và xóa
        if (isset($cart[$productId])) {
            unset($cart[$productId]); // Xóa khỏi mảng
            session()->put('cart', $cart); // Lưu lại giỏ hàng mới

            return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }

        return back()->with('error', 'Sản phẩm không tìm thấy trong giỏ hàng!');
    }
}