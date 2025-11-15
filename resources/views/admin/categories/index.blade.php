<!DOCTYPE html>
<html lang="en">
<head><title>Quản lý Danh mục</title></head>
<body>
    <h1>Tất cả Danh mục ({{ $categories->count() }})</h1>
    @if (session('success'))
        <div style="color: green; background-color: #d4edda; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
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
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}">Sửa</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type"submit" style="color: red; border: none; background: none; cursor: pointer;" 
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục {{ $category->name }} không?')">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Chưa có danh mục nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>