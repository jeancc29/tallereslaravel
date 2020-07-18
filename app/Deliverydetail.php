<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverydetail extends Model
{
    protected $fillable = [
        'idEntrega', 
        'idProducto', 
        'cantidad', 
        'idEmpleado', 
        'idUnidad', 
        'detalles', 
    ];

    public function producto()
    {
        return $this->hasOne('App\Product', 'id', 'idProducto');
    }

    public function unidad()
    {
        return $this->hasOne('App\Unit', 'id', 'idUnidad');
    }
}
