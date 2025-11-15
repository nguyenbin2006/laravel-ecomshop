<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
</head>
<body>
    <h1>Thông tin Thanh toán</h1>
    <a href="{{ route('cart.index') }}">Quay lại Giỏ hàng</a>
    <hr>

    @if ($errors->any())
        <div style="color: red;">
            <strong>Rất tiếc! Đã có lỗi xảy ra:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; background-color: #f8d7da; padding: 10px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif
    
    <div style="display: flex; gap: 30px;">
        <div style="width: 50%;">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <h3>Thông tin người nhận</h3>
                
                @auth
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div style="margin-bottom: 10px;">
                        <label for="customer_name">Họ và Tên:</label><br>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <label for="customer_email">Email:</label><br>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required>
                    </div>
                @else
                    <div style="margin-bottom: 10px;">
                        <label for="customer_name">Họ và Tên:</label><br>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <label for="customer_email">Email:</label><br>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                    </div>
                @endauth
                
                <div style="margin-bottom: 10px;">
                    <label for="customer_phone">Số điện thoại:</label><br>
                    <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="shipping_address">Địa chỉ nhận hàng:</label><br>
                    <textarea id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                </div>

                <hr>
                <p>Chọn phương thức thanh toán: (COD)</p>
                <input type="radio" name="payment_method" value="cod" checked> Thanh toán khi nhận hàng (COD)
                
                <hr>
                <button type="submit" style="background: blue; color: white; padding: 10px; font-size: 16px;">
                    Xác nhận Đặt hàng
                </button>
            </form>
        </div>

        <div style="width: 40%; background: #f4f4f4; padding: 15px;">
            <h3>Đơn hàng của bạn</h3>
            @foreach ($cart as $id => $details)
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #ccc; padding: 5px 0;">
                    <p>{{ $details['name'] }} (x {{ $details['quantity'] }})</p>
                    <p>{{ number_format($details['price'] * $details['quantity']) }} VND</p>
                </div>
            @endforeach
            <hr>
            <h4 style="display: flex; justify-content: space-between;">
                <span>Tổng cộng:</span>
                <span>{{ number_format($totalPrice) }} VND</span>
            </h4>
        </div>
    </div>
</body>
</html>