<?php

namespace App\Models;

use App\Models\Order;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_type_id', 'name', 'image', 'price', 'detail_images', 'video_link','description','sku'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'detail_images' => 'array',
    ];

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id')->withTrashed();
    }

    public function getImageAttribute()
    {
        return '/storage/products/' . $this->attributes['image'];
    }

    public function getDetailImage($detail_image)
    {
        return '/storage/' . substr($detail_image, 7);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
