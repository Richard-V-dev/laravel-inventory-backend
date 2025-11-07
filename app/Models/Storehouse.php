<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storehouse extends Model
{
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function notes(){
        return $this->belongsToMany(Note::class)
                    ->withPivot(["quantity","movement_type","unit_purchase_price","unit_sales_price","observations"])
                    ->withTimestamps();
    }
    public function products(){
        return $this->belongsToMany(Product::class)
                    ->withPivot(["current_quantity","update_date"])
                    ->withTimestamps();
    }
}
