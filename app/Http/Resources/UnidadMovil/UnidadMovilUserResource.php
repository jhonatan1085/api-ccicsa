<?php

namespace App\Http\Resources\UnidadMovil;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnidadMovilUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "fecha_alta" => $this->fecha_alta,
            "fecha_baja" => $this->fecha_baja ? $this->fecha_baja: NULL,
            "km_inicial" => $this->km_inicial,
            "km_final" => $this->km_final ? $this->km_final: NULL,
            "estado" => $this->estado,
            "user_id" => $this->user  ? [
                "id" =>$this->user->id,
                "nombre" =>$this->user->name . " " . $this->user->surname
            ]: NULL,
            "unidad_movil" =>  $this->unidad_movil ? [
                "id" => $this->unidad_movil->id,
                "placa" => $this->unidad_movil->placa,
            ]: NULL 
        ];
    }
}
