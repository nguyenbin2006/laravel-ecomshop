<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm, dùng 'with' để lấy luôn thông tin Category (Tối ưu SQL)
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        // Lấy tất cả danh mục để làm dropdown <select>
        $categories = Category::orderBy('name', 'asc')->get();
        
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id', // Phải tồn tại trong bảng categories
            'name' => 'required|string|max:255|unique:products',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Là ảnh, max 2MB
        ]);

        // 2. Xử lý Upload Ảnh (Nếu có)
        if ($request->hasFile('image')) {
            // Tạo một tên file duy nhất
            $imageName = time().'.'.$request->image->extension();  
            
            // Lưu ảnh vào thư mục 'public/products'
            // Đường dẫn lưu sẽ là: storage/app/public/products/ten_anh.jpg
            $imagePath = $request->image->storeAs('products', $imageName, 'public');
            
            // Lưu đường dẫn vào CSDL (ví dụ: 'products/ten_anh.jpg')
            $validated['image'] = $imagePath;
        }

        // 3. Xử lý Slug (Nếu rỗng thì tự tạo)
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'], '-');
        }

        // 4. Tạo sản phẩm trong CSDL
        Product::create($validated);

        // 5. Quay về trang danh sách
        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm mới thành công!');
    }

    public function edit(Product $product)
    {
        // Lấy tất cả danh mục để làm dropdown
        $categories = Category::orderBy('name', 'asc')->get();
        
        // Trả về view 'edit' và truyền sản phẩm, danh mục vào
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // 1. Validate (Quy tắc 'unique' cần loại trừ chính nó)
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id), // Loại trừ ID hiện tại
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id), // Loại trừ ID hiện tại
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Ảnh không bắt buộc
        ]);

        // 2. Xử lý Upload Ảnh MỚI (Nếu có)
        if ($request->hasFile('image')) {
            // a. Xóa ảnh cũ (nếu có)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // b. Lưu ảnh mới
            $imageName = time().'.'.$request->image->extension();  
            $imagePath = $request->image->storeAs('products', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // 3. Xử lý Slug (Nếu rỗng thì tự tạo)
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'], '-');
        }

        // 4. Cập nhật CSDL
        $product->update($validated);

        // 5. Quay về trang danh sách
        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        // 1. Xóa file ảnh (nếu có)
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Xóa sản phẩm khỏi CSDL
        $product->delete();

        // 3. Quay về trang danh sách
        return redirect()->route('admin.products.index')
            ->with('success', 'Đã xóa sản phẩm thành công!');
    }
}
