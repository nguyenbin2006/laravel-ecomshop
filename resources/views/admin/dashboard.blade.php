@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chào mừng Admin!</h3>
            </div>
            <div class="card-body">
                <p>Đây là trang quản trị Ecom-Shop. Bạn có thể quản lý các tài nguyên của mình bằng thanh điều hướng bên trái.</p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quản lý Sản phẩm</a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-info">Quản lý Danh mục</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thống kê nhanh (Demo)</h3>
            </div>
            <div class="card-body">
                <p>Bạn có thể thêm các biểu đồ và thống kê ở đây.</p>
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-boxes"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tổng số Sản phẩm</span>
                    <span class="info-box-number"> ({{ \App\Models\Product::count() }})</span>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection