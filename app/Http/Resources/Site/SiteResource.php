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
            "id" => $this->resource->id,
            "codigo" => $this->resource->codigo,
            "nombre" => $this->resource->nombre,
            "latitud" => $this->resource->latitud,
            "longitud" => $this->resource->longitud,
            "direccion" => $this->resource->direccion,

            "municipalidade" => $this->resource->municipalidade ? [
                "id" => $this->resource->municipalidade->id,
                "nombre" => $this->resource->municipalidade->nombre,
            ]: NULL,

            "distrito" => $this->resource->distrito ? [
                "id" => $this->resource->distrito->id,
                "nombre" => $this->resource->distrito->nombre,
            ]: NULL,

            "tipo_site" => $this->resource->tipo_site ? [
                "id" => $this->resource->tipo_site->id,
                "nombre" => $this->resource->tipo_site->nombre,
            ]: NULL,

            "zona" => $this->resource->zona ? [
                "id" => $this->resource->zona->id,
                "nombre" => $this->resource->zona->nombre,
            ]: NULL,

            "region" => $this->resource->region ? [
                "id" => $this->resource->region->id,
                "nombre" => $this->resource->region->nombre,
            ]: NULL,

            "region_geografica" => $this->resource->region_geografica ? [
                "id" => $this->resource->region_geografica->id,
                "nombre" => $this->resource->region_geografica->nombre,
            ]: NULL,

            "tiempo_sla" => $this->resource->tiempo_sla,
            "autonomia_bts" => $this->resource->autonomia_bts,
            "autonomia_tx" => $this->resource->autonomia_tx,
            "tiempo_auto" => $this->resource->tiempo_auto,
            "tiempo_caminata" => $this->resource->tiempo_caminata,
            "tiempo_acceso" => $this->resource->tiempo_acceso,
            "suministro" => $this->resource->suministro,

            "consesionaria" => $this->resource->consesionaria ? [
                "id" => $this->resource->consesionaria->id,
                "nombre" => $this->resource->consesionaria->nombre,
            ]: NULL,

            "room_type" => $this->resource->room_type ? [
                "id" => $this->resource->room_type->id,
                "nombre" => $this->resource->room_type->nombre,
            ]: NULL,

            "contratista" => $this->resource->contratista ? [
                "id" => $this->resource->contratista->id,
                "nombre" => $this->resource->contratista->nombre,
            ]: NULL,

            "tipo_acceso" => $this->resource->tipo_acceso ? [
                "id" => $this->resource->tipo_acceso->id,
                "nombre" => $this->resource->tipo_acceso->nombre,
            ]: NULL,

            "prioridad_site" => $this->resource->prioridad_site ? [
                "id" => $this->resource->prioridad_site->id,
                "nombre" => $this->resource->prioridad_site->nombre,
            ]: NULL,

            "tipo_energia" => $this->resource->tipo_energia ? [
                "id" => $this->resource->tipo_energia->id,
                "nombre" => $this->resource->tipo_energia->nombre,
            ]: NULL,
            "provincia" => $this->resource->distrito->provincia ? [
                "id" => $this->resource->distrito->provincia->id,
                "nombre" => $this->resource->distrito->provincia->nombre,
            ]: NULL,
            "departamento" => $this->resource->distrito->provincia->departamento ? [
                "id" => $this->resource->distrito->provincia->departamento->id,
                "nombre" => $this->resource->distrito->provincia->departamento->nombre,
            ]: NULL,
            "observacion" => $this->resource->observacion 
        ];
    }
}
