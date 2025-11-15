<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công!</title>
    <style>
        body { text-align: center; padding-top: 50px; font-family: Arial, sans-serif; }
        .success-box { 
            border: 2px solid green; 
            padding: 20px; 
            display: inline-block; 
            background: #f0fff0;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h1>Cảm ơn bạn đã đặt hàng!</h1>
        <p>Đơn hàng của bạn đã được ghi nhận thành công.</p>
        <p>Mã đơn hàng của bạn là: <strong>#{{ $order->id }}</strong></p>
        <p>Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>
        
        <hr>
        <a href="{{ route('shop.index') }}">Tiếp tục mua sắm</a>
    </div>
</body>
</html>