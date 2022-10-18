<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
	public $table = 'categories';
    protected $fillable = ['name','status'];

    public function brands()
    {
    	return $this->hasMany(Brand::class);
    }

     public function product()
     {
    	return $this->belongsTo(Product::class);
    }
}
