<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'idCliente', 
        'idProyecto', 
        'idEmpleado', 
        'status', 
    ];

    public function cliente()
    {
        return $this->hasOne('App\Customer', 'id', 'idCliente');
    }

    public function proyecto()
    {
        return $this->hasOne('App\Proyect', 'id', 'idProyecto');
    }

    public function empleado()
    {
        return $this->hasOne('App\Employee', 'id', 'idEmpleado');
    }

    public function detalles()
    {
        //Modelo, foreign key, foreign key, local key, local key
        return $this->hasMany('App\Deliverydetail', 'idEntrega');
    }

}
