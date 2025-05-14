<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock_quantity',
        'image',
        'image_detail_1',
        'image_detail_2',
        'image_detail_3',
        'color',
        'material',
        'style',
        'is_active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
