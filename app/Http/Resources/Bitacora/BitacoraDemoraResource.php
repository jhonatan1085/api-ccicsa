<?php

namespace App\Http\Resources\Bitacora;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BitacoraDemoraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "tipo_demora_id" => $this->tipo_demora->id,
            "demora_nombre" => $this->tipo_demora->nombre,
            "fecha_inicio" => $this->fecha_inicio,
            "fecha_fin" => $this->fecha_fin, //Carbon::parse($this->hora)->format('H:i'),
            "orden" => $this->orden,
        ];
    }
}
