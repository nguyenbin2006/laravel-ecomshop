<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'image',
        'is_active',
    ];

    public function category()
    {
        // Một sản phẩm thuộc về một danh mục
        return $this->belongsTo(Category::class);
    }
}
