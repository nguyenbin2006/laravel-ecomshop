<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Chào mừng Admin!</h1>
    <p>Đây là trang quản trị.</p>

    <ul>
        <li><a href="{{ route('admin.categories.index') }}">Quản lý Danh mục</a></li>
        <li><a href="{{ route('admin.products.index') }}">Quản lý Sản phẩm</a></li>
    </ul>
</body>
</html>