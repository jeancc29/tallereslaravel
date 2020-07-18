<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{
    protected $fillable = [
        'idCliente', 
        'descripcion', 
        'status', 
    ];
    public function productos()
    {
        return $this->belongsToMany('App\Product', 'product_proyect', 'idProyecto', 'idProducto')->withPivot('cantidad', 'cantidadEntregada');
    }

    public function cliente()
    {
        return $this->hasOne('App\Customer', 'id', 'idCliente');
    }
}
