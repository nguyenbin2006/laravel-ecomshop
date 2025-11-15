@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')
@section('page-title', 'Quản lý Danh mục')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tất cả Danh mục ({{ $categories->count() }})</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm Danh mục mới
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
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                            <th style="width: 150px">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->description ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type"submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc muốn xóa danh mục {{ $category->name }} không?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Chưa có danh mục nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection