<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'product_id',
        'description',
        'price',
        'tax',
        'quantity',
        'status',
        'product_code',
        'bar_code',
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            
            // dd(Brand::where('id', $model->brand_id)->value('name'));
            Productfilter::create([
                'name' => $model->name,
                'brand' => Brand::where('id', $model->brand_id)->value('name'),
                'price' => $model->price,
                'image' => $model->image,
                'quantity' => $model->quantity,
                'status' => $model->status,
            ]);
        });

        self::deleted(function ($model) {
            Productfilter::find($model->id)->delete();
        });
    }
}
