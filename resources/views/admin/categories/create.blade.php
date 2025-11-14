<!DOCTYPE html>
<html lang="en">
<head><title>Tạo Danh mục mới</title></head>
<body>
    <h1>Tạo Danh mục mới</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf <div>
            <label for="name">Tên Danh mục:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label for="slug">Slug (URL):</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}">
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit">Lưu Danh mục</button>
    </form>
</body>
</html>