<?php

namespace App\Http\Resources\Bitacora;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BitacoraListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "nombre" => $this->resource->nombre,
            "fecha_inicial" => $this->resource->fecha_inicial  ? Carbon::parse($this->resource->fecha_inicial)->format("d/m/Y ") : NULL, 
            "sot" => $this->resource->sot , 
            "insidencia" => $this->resource->insidencia, 
             "tipo_averia" => $this->tipo_averia ? [
                "id" => $this->tipo_averia->id,
                "nombre" => $this->tipo_averia->nombre,
            ]: NULL,
            "red" => $this->tipo_averia ? [
                "id" => $this->red->id,
                "nombre" => $this->red->nombre,
            ]: NULL,
            "serv" => $this->serv ? [
                "id" => $this->serv->id,
                "nombre" => $this->serv->nombre,
            ]: NULL,
            "estado" => $this->estado,
            "estadotext" =>  $this->estado == '0' ? "Cerrada": "Abierta", 
        ];
    }
}
