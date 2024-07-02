<?php

namespace App\Http\Resources\Brigada;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrigadaUserResource extends JsonResource
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
            "is_lider" => $this->is_lider,
            "user" => $this->user  ? [
                "id" =>$this->user->id,
                "nombre" =>$this->user->name . " " . $this->user->surname
            ]: NULL,
            "unidad_movil" => $this->unidad_movil ? [
                "id" => $this->unidad_movil->id,
                "placa" => $this->unidad_movil->placa,
            ]: NULL
        ];
    }
}
