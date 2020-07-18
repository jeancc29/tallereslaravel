<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'descripcion', 
        'abreviatura', 
        'valor', 
        'status', 
    ];
}
