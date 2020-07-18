<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'descripcion', 
        'existencia', 
        'status', 
        'gastable', 
    ];
    public function unidades()
    {
        return $this->belongsToMany('App\Unit', 'product_unit', 'idProducto', 'idUnidad')->withPivot('pordefecto');;
    }

    public function proyectos()
    {
        return $this->belongsToMany('App\Proyect', 'product_proyect', 'idProducto', 'idProyecto')->withPivot('cantidad', 'cantidadEntregada');
    }
}
