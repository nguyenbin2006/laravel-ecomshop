<!DOCTYPE html>
<html lang="en">
<head><title>Tạo Danh mục mới</title></head>
<body>
    <h1>Tạo Danh mục mới</h1>
    <a href="{{ route('admin.categories.index') }}">Quay lại danh sách</a>
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

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf <div style="margin-bottom: 10px;">
            <label for="name">Tên Danh mục:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" style="width: 300px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="slug">Slug (URL - để trống sẽ tự tạo):</label><br>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" style="width: 300px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="description">Mô tả:</label><br>
            <textarea id="description" name="description" rows="4" style="width: 300px;">{{ old('description') }}</textarea>
        </div>
        
        <button type="submit">Lưu Danh mục</button>
    </form>
</body>
</html>