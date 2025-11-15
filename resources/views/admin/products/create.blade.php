<!DOCTYPE html>
<html lang="en">
<head><title>Tạo Sản phẩm mới</title></head>
<body>
    <h1>Tạo Sản phẩm mới</h1>
    <a href="{{ route('admin.products.index') }}">Quay lại danh sách</a>
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 10px;">
            <label for="category_id">Danh mục:</label><br>
            <select name="category_id" id="category_id">
                <option value="">-- Chọn Danh mục --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="name">Tên Sản phẩm:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" style="width: 300px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="slug">Slug (URL - để trống sẽ tự tạo):</label><br>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" style="width: 300px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" value="{{ old('price') }}" step="1000">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="stock_quantity">Số lượng tồn kho:</label><br>
            <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="image">Ảnh Sản phẩm:</label><br>
            <input type="file" id="image" name="image">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="description">Mô tả:</label><br>
            <textarea id="description" name="description" rows="4" style="width: 300px;">{{ old('description') }}</textarea>
        </div>
        
        <button type="submit">Lưu Sản phẩm</button>
    </form>
</body>
</html>