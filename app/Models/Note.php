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
    public function products(){
        return $this->belongsToMany(Product::class)
                    ->withPivot(["quantity","movement_type","unit_purchase_price","unit_sales_price","observations"])
                    ->withTimestamps();
    }
    /**borrar? */
    public function storehouses(){
        return $this->belongsToMany(Storehouse::class)
                    ->withPivot(["quantity","movement_type","unit_purchase_price","unit_sales_price","observations"])
                    ->withTimestamps();
    }
}
