<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-g">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
</head>
<body>
    <a href="{{ route('shop.index') }}">Quay lại Cửa hàng</a>
    <a href="{{ route('cart.index') }}" style="margin-left: 20px; font-weight: bold;">
        Giỏ hàng ({{ count(session('cart', [])) }}) </a>
    <hr>

    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" height="300">
    @endif
    
    <h1>{{ $product->name }}</h1>
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
    <p>Danh mục: {{ $product->category->name ?? 'N/A' }}</p>
    <p>{!! nl2br(e($product->description)) !!}</p> <h3>{{ number_format($product->price) }} VND</h3>
    <p>Số lượng còn lại: {{ $product->stock_quantity }}</p>

    <hr>
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div>
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
        </div>
        <button type="submit">Thêm vào giỏ</button>
    </form>

</body>
</html>