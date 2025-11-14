<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storehouse extends Model
{
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class)
                    ->withPivot(["current_quantity","update_date"])
                    ->withTimestamps();
    }
}
