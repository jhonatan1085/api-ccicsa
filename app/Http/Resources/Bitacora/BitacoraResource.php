<?php

namespace App\Http\Resources\Bitacora;

use App\Http\Resources\Brigada\BrigadaResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BitacoraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        parent::wrap(null);
        return [
            "id" => $this->resource->id,
            "nombre" => $this->resource->nombre,
           // "fecha_inicial" => $this->resource->fecha_inicial  ? Carbon::parse($this->resource->fecha_inicial)->format("Y-m-d") : NULL,
            "fecha_inicial" => $this->resource->fecha_inicial  ? $this->resource->fecha_inicial  : NULL,
            "sot" => $this->resource->sot,
            "incidencia" => $this->resource->incidencia,
            "tipo_averia" => $this->tipo_averia ? [
                "id" => $this->tipo_averia->id,
                "nombre" => $this->tipo_averia->nombre,
            ] : NULL,
            "red" => $this->tipo_averia ? [
                "id" => $this->red->id,
                "nombre" => $this->red->nombre,
            ] : NULL,
            "serv" => $this->serv ? [
                "id" => $this->serv->id,
                "nombre" => $this->serv->nombre,
            ] : NULL,
            "resp_cicsa" => $this->resp_cicsa ? [
                "id" => $this->resp_cicsa->id,
                "nombres" => $this->resp_cicsa->name . " " . $this->resp_cicsa->surname,
                "telefono" => $this->resp_cicsa->cel_corp ? $this->resp_cicsa->cel_corp : $this->resp_cicsa->cel_per
            ] : NULL,
            "resp_claro" => $this->resp_claro ? [
                "id" => $this->resp_claro->id,
                "nombres" => $this->resp_claro->name . " " . $this->resp_claro->surname,
                "telefono" => $this->resp_claro->cel_corp ? $this->resp_claro->cel_corp : $this->resp_claro->cel_per
            ] : NULL,
            "estado" => $this->estado,
            "estadotext" =>  $this->estado == '0' ? "Cerrada" : "Abierta",
            "latitud" =>  $this->latitud,
            "longitud" =>  $this->longitud,
            "distancia" =>  $this->distancia,
            "site" =>    $this->site ? [
                "id" => $this->site->id,
                "nombre" => $this->site->nombre,
                "region" =>  $this->site->region->nombre,
                "distrito" => $this->site->distrito ? [
                    "id" => $this->site->distrito->id,
                    "nombre" => $this->site->distrito->nombre,
                ] : NULL,
                "departamento" => $this->site->distrito->provincia->departamento ? [
                    "id" => $this->site->distrito->provincia->departamento->id,
                    "nombre" => $this->site->distrito->provincia->departamento->nombre,
                ] : NULL,
                "tipo_site" => $this->site->tipo_site ? [
                    "id" => $this->site->tipo_site->id,
                    "nombre" => $this->site->tipo_site->nombre == 'POP' ?  $this->site->tipo_site->nombre : 'SITE',
                ] : NULL,
            ] : NULL,
            "cliente" => $this->cliente,
            "brigadas" => BrigadaResource::collection($this->brigadas),
            "tiempo_solucion" => $this->tiempo_solucion,
            "herramientas" => $this->herramientas,
            "causa_averia" => $this->causa_averia ? [
                "id" => $this->causa_averia->id,
                "nombre" => $this->causa_averia->nombre,
            ] : NULL,
            "consecuencia_averia" => $this->consecuencia_averia ? [
                "id" => $this->consecuencia_averia->id,
                "nombre" => $this->consecuencia_averia->nombre,
            ] : NULL,
            "tipo_reparacion" => $this->tipo_reparacion ? [
                "id" => $this->tipo_reparacion->id,
                "nombre" => $this->tipo_reparacion->nombre,
            ] : NULL,
            "atenciones" => BitacoraAtencionResource::collection($this->bitacora_atencion->sortByDesc('orden'))
        ];
    }
}
