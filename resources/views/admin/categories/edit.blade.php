@extends('layouts.admin')

@section('title', 'Sửa Danh mục')
@section('page-title')
    Sửa Danh mục: <span class="text-primary">{{ $category->name }}</span>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Sửa Danh mục</h3>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <strong>Rất tiếc! Đã có lỗi xảy ra:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT') <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên Danh mục</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật Danh mục</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
        </div>
</div>
@endsection