@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('page-title', 'Quản lý Sản phẩm')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tất cả Sản phẩm ({{ $products->count() }})</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm Sản phẩm mới
                    </a>
                </div>
            </div>
            
            <div class="card-body table-responsive p-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible m-3">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Ảnh</th>
                            <th>Tên Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th style="width: 150px">Hành động</th>
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
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->price) }} VND</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm {{ $product->name }} không?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Chưa có sản phẩm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>
</div>
@endsection