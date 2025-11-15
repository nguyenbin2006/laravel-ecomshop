<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-2xl font-bold text-indigo-600">
                Ecom-Shop
            </a>
            <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-indigo-600">
                Quay lại Giỏ hàng
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Hoàn tất Đơn hàng</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Rất tiếc! Đã có lỗi xảy ra:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col lg:flex-row gap-8">
            @csrf
            
            <div class="lg:w-2/3">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Thông tin người nhận</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Họ và Tên</label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        @else
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Họ và Tên</label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        @endauth
                        
                        <div class="md:col-span-2">
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                            <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700">Địa chỉ nhận hàng</label>
                            <textarea id="shipping_address" name="shipping_address" rows="3" required
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('shipping_address') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white shadow-md rounded-lg p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Đơn hàng của bạn</h2>
                    
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @foreach ($cart as $id => $details)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('storage/'. $details['image']) }}" alt="{{ $details['name'] }}" class="h-12 w-12 object-cover rounded-md">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $details['name'] }}</div>
                                        <div class="text-sm text-gray-500">Số lượng: {{ $details['quantity'] }}</div>
                                    </div>
                                </div>
                                <div class="font-medium text-gray-900">{{ number_format($details['price'] * $details['quantity']) }} VND</div>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr class="my-4">
                    
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

                    <div class="mb-4">
                        <h3 class="text-md font-medium text-gray-900 mb-2">Phương thức thanh toán</h3>
                        <div class="border border-gray-300 rounded-md p-3 bg-gray-50">
                            <input type="radio" name="payment_method" value="cod" id="cod" checked class="text-indigo-600 focus:ring-indigo-500">
                            <label for="cod" class="ml-2 font-medium text-gray-700">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md font-semibold text-lg
                                   hover:bg-indigo-700 transition duration-300">
                        Xác nhận Đặt hàng
                    </button>
                </div>
            </div>
        </form>
        
    </div>

</body>
</html>