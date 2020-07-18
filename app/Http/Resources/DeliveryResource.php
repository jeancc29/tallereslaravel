<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DeliverydetailsResource;

class DeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'idCliente' => $this->idCliente,
            'idProyecto' => $this->idProyecto,
            'idEmpleado' => $this->idEmpleado,
            'cliente' => $this->cliente,
            'proyecto' => $this->proyecto,
            'empleado' => $this->empleado,
            // 'detalle' => $this->detalle,
            'detalles' => DeliverydetailsResource::collection($this->detalles),
            'status' => $this->status,
        ];
    }
}
