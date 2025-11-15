<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng Ecom-Shop</title>
    <style>
        .product-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .product-card { border: 1px solid #ccc; padding: 15px; }
        .product-card img { max-width: 100%; height: 200px; object-fit: cover; }
        .pagination { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Chào mừng đến với Cửa hàng</h1>
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
    <a href="{{ route('login') }}">Đăng nhập (Admin)</a>
    <a href="{{ route('cart.index') }}" style="margin-left: 20px; font-weight: bold;">
        Giỏ hàng ({{ count(session('cart', [])) }}) </a>
    <hr>

    <h2>Sản phẩm Mới nhất</h2>

    <div class="product-grid">
        @forelse ($products as $product)
            <div class="product-card">
                <a href="{{ route('shop.product.show', $product->slug) }}">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x200" alt="Ảnh mặc định">
                    @endif
                    <h3>{{ $product->name }}</h3>
                </a>
                <p>Danh mục: {{ $product->category->name ?? 'N/A' }}</p>
                <h4>{{ number_format($product->price) }} VND</h4>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                    <button type="submit">Thêm vào giỏ</button>
                </form>
                </div>
        @empty
            <p>Hiện chưa có sản phẩm nào.</p>
        @endforelse
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>

</body>
</html>