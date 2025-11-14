<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function movements(){
        return $this->belongsToMany(Storehouse::class,"movement")
                    ->withPivot(["product_id","quantity","movement_type","unit_purchase_price","unit_sales_price","observations"])
                    ->withTimestamps();
    }
}
