<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /**
     * Kolom yang boleh diisi lewat create() / update()
     */
    protected $fillable = [
        'slug',
        'brand',
        'name',
        'category',
        'price',
        'stock',        // 🔥 WAJIB ADA
        'description',
        'image_path',
    ];

    /**
     * Auto-generate slug saat create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $slug = Str::slug($product->name);

                $count = static::whereRaw(
                    "slug RLIKE '^{$slug}(-[0-9]+)?$'"
                )->count();

                $product->slug = $count > 0
                    ? "{$slug}-{$count}"
                    : $slug;
            }
        });
    }

    /**
     * Relationship ke orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
