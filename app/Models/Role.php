<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users(){
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }
    public function permits(){
        return $this->belongsToMany(Permit::class)
                    ->withTimestamps();
    }
    public function branches(){
        return $this->belongsToMany(Branch::class)
                    ->withTimestamps();
    }

}
