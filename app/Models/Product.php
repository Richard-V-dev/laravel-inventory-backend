<?php

namespace App\Models;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function storehouses(){
        return $this->belongsToMany(Storehouse::class)
                    ->withPivot(["current_quantity","update_date"])
                    ->withTimestamps();
    }
}
