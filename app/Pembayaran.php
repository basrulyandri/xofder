<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
	protected $table = 'pembayaran';

	protected $fillable = ['order_id','nominal'];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
