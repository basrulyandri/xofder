<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['tanggal','product_id','user_id','stock_in','store_id','stock_from','stock_from_id','stock_out','description'];
    protected $dates = ['tanggal'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function supplier()
    {
    	return $this->belongsTo(Supplier::class,'stock_from_id');
    }

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
