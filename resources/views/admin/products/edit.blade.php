@extends('layouts.admin')

@section('title', 'Sửa Sản phẩm')
@section('page-title')
    Sửa Sản phẩm: <span class="text-primary">{{ $product->name }}</span>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Sửa Sản phẩm</h3>
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

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="card-body">
                    
                    <div class="form-group">
                        <label for="name">Tên Sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $product->slug) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">Danh mục</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">-- Chọn Danh mục --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" step="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stock_quantity">Số lượng tồn kho</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Ảnh Sản phẩm (Để trống nếu không muốn đổi)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Chọn file mới</label>
                            </div>
                        </div>
                        @if ($product->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" height="100">
                                <small class="d-block">Ảnh hiện tại</small>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật Sản phẩm</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
        </div>
</div>
@endsection