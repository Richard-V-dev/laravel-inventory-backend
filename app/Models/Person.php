<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
