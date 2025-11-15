<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
</head>
<body>
    <h1>Giỏ hàng của bạn</h1>
    <a href="{{ route('shop.index') }}">Tiếp tục mua sắm</a>
    <hr>

    @if (session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div style="color: red; background-color: #f8d7da; padding: 10px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if (empty($cart))
        <p>Giỏ hàng của bạn đang trống.</p>
    @else
        <table border="1" style="width: 100%;">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng cộng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($cart as $id => $details)
    <tr>
        <td>
            @if ($details['image'])
                <img src="{{ asset('storage/'. $details['image']) }}" alt="{{ $details['name'] }}" height="50">
            @else
                (không có ảnh)
            @endif
        </td>
        <td>{{ $details['name'] }}</td>
        <td>{{ number_format($details['price']) }} VND</td>
        <td>
            <form action="{{ route('cart.update') }}" method="POST" style="display: inline-block;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $id }}">
                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" style="width: 60px;">
                <button type="submit">Cập nhật</button>
            </form>
        </td>
        <td>{{ number_format($details['price'] * $details['quantity']) }} VND</td>
        <td>
            <form action="{{ route('cart.remove') }}" method="POST" style="display: inline-block;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $id }}">
                <button type="submit" style="color: red;">Xóa</button>
            </form>
        </td>
    </tr>
    @endforeach
            </tbody>
        </table>

        <hr>
        <div style="text-align: right; margin-top: 20px;">
            <h3>Tổng cộng: {{ number_format($totalPrice) }} VND</h3>
            <a href="{{ route('checkout.index') }}" style="background: green; color: white; padding: 10px; text-decoration: none;">
                Tiến hành Thanh toán
            </a>
        </div>
    @endif

</body>
</html>