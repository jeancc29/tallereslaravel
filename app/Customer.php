<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'nombre', 
        'status', 
    ];

    public function proyectos()
    {
        //Modelo, foreign key, foreign key, local key, local key
        return $this->hasMany('App\Proyect', 'idCliente');
    }
}
