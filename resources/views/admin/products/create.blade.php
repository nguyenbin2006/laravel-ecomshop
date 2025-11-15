@extends('layouts.admin')

@section('title', 'Thêm Sản phẩm mới')
@section('page-title', 'Thêm Sản phẩm mới')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Thêm Sản phẩm</h3>
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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="name">Tên Sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (URL - để trống sẽ tự tạo)</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="ten-san-pham" value="{{ old('slug') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">Danh mục</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">-- Chọn Danh mục --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" step="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock_quantity">Số lượng tồn kho</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Ảnh Sản phẩm</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Chọn file</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Lưu Sản phẩm</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
        </div>
</div>
@endsection