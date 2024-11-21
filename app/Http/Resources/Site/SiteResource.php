<?php

namespace App\Http\Resources\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
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
            "codigo" => $this->codigo,
            "nombre" => $this->nombre,
            "latitud" => $this->latitud,
            "longitud" => $this->longitud,
            "direccion" => $this->direccion,
            "tipo_site" => $this->tipo_site ? [
                "id" => $this->tipo_site->id,
                "nombre" => $this->tipo_site->nombre,
            ]: NULL,

            "zona" => $this->zona ? [
                "id" => $this->zona->id,
                "nombre" => $this->zona->nombre,
            ]: NULL,

            "region" => $this->region ? [
                "id" => $this->region->id,
                "nombre" => $this->region->nombre,
            ]: NULL,

            "region_geografica" => $this->region_geografica ? [
                "id" => $this->region_geografica->id,
                "nombre" => $this->region_geografica->nombre,
            ]: NULL,

            "municipalidade" => $this->municipalidade ? [
                "id" => $this->municipalidade->id,
                "nombre" => $this->municipalidade->nombre,
            ]: NULL,

            "distrito" => $this->municipalidade->distrito ? [
                "id" => $this->municipalidade ->distrito->id,
                "nombre" => $this->municipalidade ->distrito->nombre,
            ]: NULL,
            "provincia" => $this->municipalidade->distrito->provincia ? [
                "id" => $this->municipalidade->distrito->provincia->id,
                "nombre" => $this->municipalidade->distrito->provincia->nombre,
            ]: NULL,
            "departamento" => $this->municipalidade->distrito->provincia->departamento ? [
                "id" => $this->municipalidade->distrito->provincia->departamento->id,
                "nombre" => $this->municipalidade->distrito->provincia->departamento->nombre,
            ]: NULL,
            "observacion" => $this->observacion 
        ];
    }
}
