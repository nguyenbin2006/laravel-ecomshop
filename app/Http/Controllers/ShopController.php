<?php

namespace App\Http\Controllers;

use App\Models\Product; // <-- Thêm
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Lấy các sản phẩm đang 'active', sắp xếp mới nhất
        $products = Product::with('category')
                            ->where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->paginate(12); // Phân trang 12 sản phẩm/trang

        // Trả về view (chúng ta sẽ tạo ngay sau đây)
        return view('shop.index', compact('products'));
    }

    /**
     * Hiển thị trang chi tiết một sản phẩm
     */
    public function show($slug)
    {
        $product = Product::with('category')
                        ->where('slug', $slug)
                        ->where('is_active', true)
                        ->firstOrFail();
        return view('shop.show', compact('product'));
    }
}