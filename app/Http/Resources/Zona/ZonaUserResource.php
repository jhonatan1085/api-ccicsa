<?php

namespace App\Http\Resources\Zona;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonaUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                "id" => $this->zona->id,
                "nombre" =>$this->zona->nombre
        ];
    }
}
