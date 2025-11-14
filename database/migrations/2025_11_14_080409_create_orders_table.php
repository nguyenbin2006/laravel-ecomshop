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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // 1. Khóa ngoại: Đơn hàng này của User nào?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('shipping_address');
            
            // 2. Tổng tiền của đơn hàng
            $table->decimal('total_price', 15, 2); // Tổng tiền lớn, 15 chữ số, 2 số thập phân
            
            // 3. Trạng thái đơn hàng
            $table->string('status')->default('pending'); // (pending, processing, completed, cancelled)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
