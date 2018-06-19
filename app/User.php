<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','username','password','activated','role_id','first_name','last_name','photo','remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('\App\Role');
    }

    public function getNameOrEmail($fullname = false)
    {
        if($this->first_name){
            if($fullname == true){
                return $this->first_name.' '.$this->last_name;
            }else {
                return $this->first_name;
            }
        }

        return $this->email;
    }

    public function canAccess($routeName)
    {
        $role = \Auth::user()->role;
        $permissions = [];
        foreach($role->permissions as $perm){
            array_push($permissions,$perm->name_permission);
        }
        // if (\Auth::user()->role->name == 'Superadmin') {
        //     return true;
        // }

        if(!in_array($routeName,$permissions) AND \Auth::user()->role->name !== 'Superadmin'){
            return false;
        }

        return true;
    }   

    public function isAdmin()
    {
        if(in_array($this->role->name,['Superadmin','Administrator'])){
            return true;
        }

        return false;
    }

    public function isKasir()
    {
        if(auth()->user()->role_id == 7){
            return true;
        }
        return false;
    }

    public function getAvatarUrl()
    {
        if($this->photo){
            return url('/uploads/user-photos').'/'.$this->photo;
        }

        return url('assets/backend/img').'/default.jpg';
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function saldo($type)
    {
        if($type == 'eWallet'){
            return $this->anggota->saldo_ewallet;
        }
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
