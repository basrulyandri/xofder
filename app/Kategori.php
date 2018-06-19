<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    use Sluggable;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }
}
