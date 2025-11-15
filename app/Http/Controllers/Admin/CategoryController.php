<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

    public function edit(Category $category)
    {
        // Trả về view 'edit' và truyền Category đó vào
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        // 1. Validate (Quy tắc 'unique' cần phải loại trừ chính nó)
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id), // Loại trừ ID hiện tại
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id), // Loại trừ ID hiện tại
            ],
            'description' => 'nullable|string',
        ]);

        // 2. Tự tạo slug nếu rỗng
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'], '-');
        }

        // 3. Cập nhật CSDL
        $category->update($validated);

        // 4. Quay lại trang danh sách với thông báo
        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }
    public function destroy(Category $category)
    {
        // Xóa danh mục
        $category->delete();

        // Quay lại trang danh sách với thông báo
        return redirect()->route('admin.categories.index')
            ->with('success', 'Đã xóa danh mục thành công!');
    }
}
