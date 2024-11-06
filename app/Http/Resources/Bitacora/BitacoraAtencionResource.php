<?php

namespace App\Http\Resources\Bitacora;

use Carbon\Carbon;
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
            "hora" =>  Carbon::parse($this->hora)->format('H:i'),
            "orden" => $this->orden,
            "is_coment" => $this->is_coment,
            "descripcion" => $this->descripcion,
            "bitacora_atencion" =>BitacoraAtencionResource::collection($this->bitacora_atencion->sortByDesc('orden')),
        ];
    }
}
