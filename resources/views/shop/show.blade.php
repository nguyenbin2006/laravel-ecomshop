<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
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

        <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            &larr; Quay lại Cửa hàng
        </a>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden md:flex">
            <div class="md:w-1/2">
                @if ($product->image)
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <img class="w-full h-full object-cover" src="https://via.placeholder.com/600x400" alt="Ảnh mặc định">
                @endif
            </div>

            <div class="md:w-1/2 p-6 md:p-8">
                <p class="text-sm text-gray-500 mb-2">{{ $product->category->name ?? 'N/A' }}</p>
                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                
                <p class="text-3xl font-bold text-indigo-600 mb-4">{{ number_format($product->price) }} VND</p>

                @if ($product->stock_quantity > 0)
                    <p class="text-green-600 font-semibold mb-4">Còn hàng ({{ $product->stock_quantity }} sản phẩm)</p>
                @else
                    <p class="text-red-600 font-semibold mb-4">Hết hàng</p>
                @endif
                
                <div class="text-gray-700 mb-6">
                    <h3 class="text-lg font-semibold mb-2">Mô tả sản phẩm</h3>
                    <p>{!! nl2br(e($product->description)) !!}</p> </div>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="text-lg font-semibold text-gray-800 mr-4">Số lượng:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                               class="w-20 p-2 border rounded-md text-center"
                               {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold text-lg
                                   hover:bg-indigo-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                        {{ $product->stock_quantity <= 0 ? 'Hết hàng' : 'Thêm vào giỏ' }}
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>