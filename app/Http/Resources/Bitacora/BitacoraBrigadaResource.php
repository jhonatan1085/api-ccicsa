<?php

namespace App\Http\Resources\Bitacora;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BitacoraBrigadaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->brigada->id,
            "estado" => $this->brigada->estado,
            "estadotext" => $this->brigada->estado == '1' ? "Activo": "inactivo",
            "nombre" => $this->brigada->nombre,
            "contratista" => $this->brigada->contratista ? [
                "id" => $this->brigada->contratista->id,
                "nombre" => $this->brigada->contratista->nombre,
            ]: NULL,
            "tipo_brigada" => $this->brigada->tipo_brigada ? [
                "id" => $this->brigada->tipo_brigada->id,
                "nombre" => $this->brigada->tipo_brigada->nombre,
            ]: NULL,
            "zona" => $this->brigada->zona ? [
                "id" => $this->brigada->zona->id,
                "nombre" => $this->brigada->zona->nombre,
            ]: NULL,
             "user_movil" => BitacoraBrigadaUserResource::collection($this->usuarios),
        ];
    }
}
