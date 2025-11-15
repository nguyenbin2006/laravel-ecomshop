<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// 1. Trang chủ (Danh sách sản phẩm)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// 2. Trang chi tiết sản phẩm
Route::get('/shop/product/{slug}', [ShopController::class, 'show'])->name('shop.product.show');

// 1. Xem giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// 2. Thêm vào giỏ hàng
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// 3. Cập nhật giỏ hàng
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
// 4. Xóa khỏi giỏ hàng
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// 1. Hiển thị trang checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// 2. Xử lý đặt hàng
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
// 3. Trang Cảm ơn
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/dashboard', function () {
    // Kiểm tra xem người dùng đã đăng nhập có phải là admin không
    if (Auth::user()->is_admin) {
        // Nếu là Admin, chuyển hướng sang trang Admin Dashboard
        return redirect()->route('admin.dashboard');
    } else {
        // Nếu là User thường, hiển thị trang dashboard bình thường
        return redirect()->route('shop.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () { // <-- DÁN VÀO ĐÂY
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';

// == ADMIN ROUTES ==
// SỬA LỖI: prefix('admin') KHÔNG CÓ DẤU CHẤM
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Trang Dashboard Admin
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard'); // Tên đúng: admin.dashboard

    // CRUD cho Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // CRUD cho Products
    Route::resource('products', ProductController::class); // Tên đúng: admin.products.index, v.v.

    Route::resource('users', UserController::class)->only(['index', 'destroy']);
});
