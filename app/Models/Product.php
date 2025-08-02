<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'image',
        'sku',
        'barcode',
        'min_stock',
        'max_stock'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'min_stock' => 'integer',
        'max_stock' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Accessor untuk status stok
    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= $this->min_stock) {
            return 'low';
        } elseif ($this->stock_quantity >= $this->max_stock) {
            return 'high';
        }
        return 'normal';
    }

    // Accessor untuk persentase stok
    public function getStockPercentageAttribute()
    {
        if ($this->max_stock > 0) {
            return round(($this->stock_quantity / $this->max_stock) * 100, 2);
        }
        return 0;
    }

    // Scope untuk produk dengan stok rendah
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= min_stock');
    }

    // Scope untuk produk dengan stok tinggi
    public function scopeHighStock($query)
    {
        return $query->whereRaw('stock_quantity >= max_stock');
    }

    // Generate SKU otomatis
    public static function generateSKU($categoryId)
    {
        $category = Category::find($categoryId);
        $prefix = strtoupper(substr($category->name, 0, 3));
        $count = self::where('category_id', $categoryId)->count() + 1;
        return $prefix . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
