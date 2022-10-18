<?php

namespace App\Models;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','total_amount','payment_method','order_status','cashier_name','discount'];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function products()
    {
    	return $this->belongsToMany(Product::class,'order_products')->withPivot('quantity');
    }
}
