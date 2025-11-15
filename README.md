# Dự án E-commerce: Ecom-Shop (Laravel)

Đây là một dự án E-commerce đầy đủ chức năng được xây dựng bằng Laravel Framework. 
Dự án bao gồm trang quản trị và trang cửa hàng hiện đại.

## 📸 (Ảnh chụp màn hình)

| Trang Cửa hàng (Storefront) | Trang Giỏ hàng | Trang Admin (Quản lý Sản phẩm) 
| ![Trang Shop](https://github.com/nguyenbin2006/laravel-ecomshop/blob/main/shop.png?raw=true) 
| ![Trang Giỏ hàng](https://github.com/nguyenbin2006/laravel-ecomshop/blob/main/cart.png?raw=true) 
| ![Trang Admin](https://github.com/nguyenbin2006/laravel-ecomshop/blob/main/admin.png?raw=true) 

---

## 🚀 Các Tính Năng Chính

Dự án được chia làm 2 phần chính với các tính năng cần dùng:

### 1. Trang Quản trị (Admin Panel)
* **Phân quyền:** Xác thực (Login) và Phân quyền (Middleware) cho Admin.
* **CRUD Sản phẩm:** Quản lý sản phẩm (Thêm, Sửa, Xóa), bao gồm **Upload Ảnh** và xử lý **Khóa ngoại** (với Danh mục).
* **CRUD Danh mục:** Quản lý danh mục sản phẩm.
* **CRUD Người dùng:** Quản lý tài khoản người dùng (Admin/User).
* **Giao diện:** Sử dụng template **AdminLTE 3** (Bootstrap).

### 2. Cửa hàng (Storefront) & Logic E-commerce
* **Giỏ hàng:** Quản lý giỏ hàng bằng **Session** (Thêm, Sửa, Xóa sản phẩm).
* **Đặt hàng (Checkout):** Form điền thông tin khách hàng và xử lý đặt hàng.
* **Database Transaction:** Đảm bảo tính toàn vẹn dữ liệu khi đặt hàng (tự động trừ kho, tạo đơn hàng).
* **Giao diện:** Sử dụng **Tailwind CSS** hiện đại, responsive.

---

## 🛠️ Công nghệ Sử dụng

* **Backend:** PHP 8.2, **Laravel 12**
* **Frontend:** HTML, **Tailwind CSS**, JavaScript
* **Admin Panel:** **AdminLTE 3** (Bootstrap 4)
* **Database:** MySQL (hoặc PostgreSQL)
* **Development:** Vite, Composer, Artisan

---

###  Cài đặt và Chạy dự án

### Clone dự án
```bash
git clone [https://github.com/nguyenbin2006/laravel-ecomshop.git](https://github.com/nguyenbin2006/laravel-ecomshop.git)
cd laravel-ecom-shop

### 2. Cài đặt Dependencies
```bash
composer install
npm install

### 3.Cấu hình môi trường
-Copy file .env.example thành .env:
```bash
cp .env.example .env

-Tạo App Key:
```bash
php artisan key:generate

-Cấu hình CSDL (Database) trong file .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecomshop
DB_USERNAME=root
DB_PASSWORD=

### 4.Khởi tạo CSDL
```bash
php artisan migrate

### 5.Tạo Storage Link
```bash
php artisan storage:link

### 6.Khởi chạy
-Terminal 1 (Biên dịch Frontend):
```bash
npm run dev

-Terminal 2 (Chạy Server):
```bash
php artisan serve

### 7.Tài khoản Admin
-Tạo một tài khoản mới tại /register.
-Vào CSDL, mở bảng users và đổi cột is_admin của tài khoản đó thành 1.
-Đăng nhập tại /login. Sẽ được chuyển hướng đến Admin Dashboard.
