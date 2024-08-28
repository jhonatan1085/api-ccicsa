<?php

namespace App\Http\Resources\User;

use App\Http\Resources\UnidadMovil\UnidadMovilResource;
use App\Http\Resources\UnidadMovil\UnidadMovilUserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "name" => $this->resource->name,
            "surname" => $this->resource->surname,
            "email" => $this->resource->email,
            "birth_date" => $this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y/m/d ") : NULL,
            "gender" => $this->resource->gender,
            "address" => $this->resource->address,
            "cel_corp" => $this->resource->cel_corp,
            "cel_per" => $this->resource->cel_per,
            "dni" => $this->resource->dni,
            "created_at" => $this->resource->created_at ? $this->resource->created_at->format("Y/m/d ") : NULL,
            "role" => $this->resource->roles ? $this->resource->roles->first(): NULL,
            "zona" => $this->resource->zona ? 
            [
                "id" => $this->resource->zona->id,
                "nombre" => $this->resource->zona->nombre,
            ]: NULL,
            "educacion" => $this->resource->educacion ? [
                "id" => $this->resource->educacion->id,
                "nombre" => $this->resource->educacion->nombre,
            ]: NULL,
            "avatar" => env("APP_URL")."storage/".$this->resource->avatar,  
            //"unidad_movil" => UnidadMovilUserResource::collection('unidad_movil_user')
        ];
    }
}
