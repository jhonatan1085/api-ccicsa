<?php

namespace App\Http\Resources\Brigada;

use App\Http\Resources\UnidadMovil\UnidadMovilResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrigadaResource extends JsonResource
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
            "estado" => $this->estado,
            "estadotext" => $this->estado == '1' ? "Activo": "inactivo",
            "nombre" => $this->nombre,
            "contratista" => $this->contratista ? [
                "id" => $this->contratista->id,
                "nombre" => $this->contratista->nombre,
            ]: NULL,
            "tipo_brigada" => $this->tipo_brigada ? [
                "id" => $this->tipo_brigada->id,
                "nombre" => $this->tipo_brigada->nombre,
            ]: NULL,
            "zona" => $this->zona ? [
                "id" => $this->zona->id,
                "nombre" => $this->zona->nombre,
            ]: NULL,
             "user_movil" => BrigadaUserResource::collection($this->whenLoaded('brigada_user_activos')),
        ];
    }
}
