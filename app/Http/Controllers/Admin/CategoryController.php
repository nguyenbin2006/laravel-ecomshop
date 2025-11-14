<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            // Nếu slug rỗng, tự động tạo. Nếu có, validate
            'slug' => 'nullable|string|max:255|unique:categories', 
            'description' => 'nullable|string',
        ]);

        // 2. Xử lý Slug (Nếu người dùng không nhập, tự tạo từ Tên)
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'], '-');
        }

        // 3. Tạo mới trong CSDL
        Category::create($validated);

        // 4. Quay lại trang danh sách với thông báo
        return redirect()->route('admin.categories.index')
        ->with('success', 'Tạo danh mục thành công!');
    }

}
