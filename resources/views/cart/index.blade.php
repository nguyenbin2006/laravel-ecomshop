<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-2xl font-bold text-indigo-600">
                Ecom-Shop
            </a>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-indigo-600">
                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ count(session('cart', [])) }}
                    </span>
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600">Admin Panel</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="text-gray-700 hover:text-indigo-600">
                           Đăng xuất
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Đăng nhập</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Giỏ hàng của bạn</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (empty($cart))
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <p class="text-lg text-gray-700">Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-indigo-600 text-white py-2 px-4 rounded-md font-semibold hover:bg-indigo-700 transition duration-300">
                    Bắt đầu mua sắm
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">

                <div class="lg:w-2/3">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng cộng</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Xóa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($cart as $id => $details)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                @if ($details['image'])
                                                    <img src="{{ asset('storage/'. $details['image']) }}" alt="{{ $details['name'] }}" class="h-16 w-16 object-cover rounded-md">
                                                @else
                                                    <div class="h-16 w-16 bg-gray-200 rounded-md flex items-center justify-center text-xs text-gray-500">No Image</div>
                                                @endif
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $details['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-700">{{ number_format($details['price']) }} VND</td>
                                        <td class="py-4 px-6">
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" 
                                                       class="w-20 p-1 border rounded-md text-center"
                                                       onchange="this.form.submit()"> </form>
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-900 font-medium">
                                            {{ number_format($details['price'] * $details['quantity']) }} VND
                                        </td>
                                        <td class="py-4 px-6">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Xóa">
                                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                        &larr; Tiếp tục mua sắm
                    </a>
                </div>

                <div class="lg:w-1/3">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Tóm tắt Đơn hàng</h2>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Tổng tiền hàng:</span>
                            <span class="text-gray-900 font-medium">{{ number_format($totalPrice) }} VND</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-700">Phí vận chuyển:</span>
                            <span class="text-gray-900 font-medium">Miễn phí</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-900">Tổng cộng:</span>
                            <span class="text-xl font-bold text-indigo-600">{{ number_format($totalPrice) }} VND</span>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" 
                           class="w-full block text-center bg-indigo-600 text-white py-3 px-4 rounded-md font-semibold
                                  hover:bg-indigo-700 transition duration-300">
                            Tiến hành Thanh toán
                        </a>
                    </div>
                </div>

            </div>
        @endif

    </div>

</body>
</html>