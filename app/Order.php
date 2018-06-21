<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','payment_method'];

    public function status()
    {
    	if($this->status == 'diforward' || $this->status == 'diterima'){
    		return 'diproses';
    	}
    	return $this->status;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function statusLabel()
    {    	
    	if($this->status() == 'lunas'){
    		return 'primary';
    	}
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function sisaHutang()
    {
        return $this->total_price - $this->pembayaran->sum('nominal');
    }
}
