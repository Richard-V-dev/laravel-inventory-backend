<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function storehouses(){
        return $this->hasMany(Storehouse::class);
    }
    public function users(){
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }
}
