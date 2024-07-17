<?php

namespace App\Http\Resources\Bitacora;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BitacoraAtencionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "atencion" =>$this->atencion ? [
                "orden" => $this->atencion->orden,
                "descripcion" => $this->atencion->descripcion,
            ] : NULL,
            "id" => $this->id,
            "hora" => $this->hora,
            "orden" => $this->orden,
            "descripcion" => $this->descripcion,
            "bitacora_atencion" =>BitacoraAtencionResource::collection($this->bitacora_atencion->sortByDesc('orden')), 
        ];
    }
}
