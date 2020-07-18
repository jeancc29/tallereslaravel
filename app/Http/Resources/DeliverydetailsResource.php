<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliverydetailsResource extends JsonResource
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
            'idProducto' => $this->idProducto,
            'idUnidad' => $this->idUnidad,
            'producto' => $this->producto,
            'unidad' => $this->unidad,
            'cantidad' => $this->cantidad,
            'detalles' => $this->detalles,
        ];
    }
}
