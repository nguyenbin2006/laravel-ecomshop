<!DOCTYPE html>
<html lang="en">
<head><title>Quản lý Sản phẩm</title></head>
<body>
    <h1>Tất cả Sản phẩm ({{ $products->count() }})</h1>

    @if (session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.dashboard') }}">Quay lại Dashboard</a>
    <hr>
    
    <a href="{{ route('admin.products.create') }}">Thêm Sản phẩm mới</a>
    
    <table border="1" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên Sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" height="50">
                    @else
                        (không có ảnh)
                    @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ number_format($product->price) }} VND</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type"submit" style="color: red; border: none; background: none; cursor: pointer;" 
                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm {{ $product->name }} không?')">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Chưa có sản phẩm nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>