<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
           // 1. Khóa ngoại: Mục này thuộc Đơn hàng (Order) nào?
           $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
           // 2. Khóa ngoại: Mục này là Sản phẩm (Product) nào?
           $table->foreignId('product_id')->constrained()->onDelete('cascade');
           
           $table->integer('quantity');
           
           // 3. Giá tại thời điểm mua (Rất quan trọng!)
           // Bạn phải lưu lại giá ở đây, vì giá sản phẩm (Product) có thể thay đổi trong tương lai
           $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
