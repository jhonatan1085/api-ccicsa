<?php

namespace App\Http\Resources\UnidadMovil;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnidadMovilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "placa" => $this->placa,
            "kilometraje" => $this->kilometraje,
            "modelo" => $this->modelo ? [
                "id" => $this->modelo->id,
                "nombre" => $this->modelo->nombre,
            ]: NULL,
            "marca" => $this->modelo->marca ? [
                "id" => $this->modelo->marca->id,
                "nombre" => $this->modelo->marca->nombre,
            ]: NULL,
            "color" => $this->color ? [
                "id" => $this->color->id,
                "nombre" => $this->color->nombre,
            ]: NULL,
            "estado" => $this->estado,
            "estadotext" => $this->estado == '1' ? "Activo": "Inactivo",
            "user" => $this->user->count() //? $this->user : NULL
        ];
    }
}
