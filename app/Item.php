<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['product_id','order_id','qty','price','buy_price'];

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }
}
