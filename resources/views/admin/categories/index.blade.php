<!DOCTYPE html>
<html lang="en">
<head><title>Quản lý Danh mục</title></head>
<body>
    <h1>Tất cả Danh mục ({{ $categories->count() }})</h1>
    <a href="{{ route('admin.dashboard') }}">Quay lại Dashboard</a>
    <hr>

    <a href="{{ route('admin.categories.create') }}">Thêm Danh mục mới</a>

    <table border="1" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        <a href="#">Sửa</a>
                        <a href="#">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>