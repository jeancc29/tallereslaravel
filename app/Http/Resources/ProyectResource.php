<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProyectResource extends JsonResource
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
            'descripcion' => $this->descripcion,
            'idCliente' => $this->idCliente,
            'status' => $this->status,
            'cliente' => $this->cliente,
            'productos' => $this->productos,
        ];
    }
}
