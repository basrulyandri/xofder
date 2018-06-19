<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	public function orders()
	{		
    	return $this->hasManyThrough('App\Order', 'App\User');
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
