<?php

namespace App\Http\Resources\Bitacora;

use App\Http\Resources\Brigada\BrigadaResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BitacorasExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $brigada = $this->bitacora_brigada->first();

        $brigadas = BrigadaResource::collection($this->brigadas);

        return [
            
            "anio" => $this->fecha_inicial  ? Carbon::parse($this->fecha_inicial)->year  : NULL,
            "mes" => $this->fecha_inicial  ? Carbon::parse($this->fecha_inicial)->locale('es')->shortMonthName  : NULL,
            "semana" => $this->fecha_inicial  ? Carbon::parse($this->fecha_inicial)->weekOfYear  : NULL,
            "hora_asignacion" => $this->fecha_ejecucion  ? Carbon::parse($this->fecha_ejecucion)->format('H:i:s') : NULL,
            "id" => $this->id,
            "nombre" => $this->nombre,
            "enlace_plano_site" => $this->enlace_plano_site,
            "fecha_inicial" => $this->fecha_inicial  ? $this->fecha_inicial  : NULL,
            "fecha_ejecucion" => $this->fecha_ejecucion  ? $this->fecha_ejecucion  : NULL,
            "sot" => $this->sot,
            "fecha_sot" => $this->resource->fecha_sot,
            "estado_sot" =>  $this->estado_sot ? "Pendiente":"Cerrada",
            "incidencia" => $this->incidencia,
            "tipo_averia" => $this->tipo_averia ? [
                "id" => $this->tipo_averia->id,
                "nombre" => $this->tipo_averia->nombre,
                "incidencia" => $this->tipo_averia->incidencia
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
                "zona" =>  $this->site->zona->nombre,
                "provincia" => $this->site->municipalidade->distrito->provincia ? [
                    "id" => $this->site->municipalidade->distrito->provincia->id,
                    "nombre" => $this->site->municipalidade->distrito->provincia->nombre,
                ] : NULL,
                
                "distrito" => $this->site->municipalidade->distrito ? [
                    "id" => $this->site->municipalidade->distrito->id,
                    "nombre" => $this->site->municipalidade->distrito->nombre,
                ] : NULL,
                "departamento" => $this->site->municipalidade->distrito->provincia->departamento ? [
                    "id" => $this->site->municipalidade->distrito->provincia->departamento->id,
                    "nombre" => $this->site->municipalidade->distrito->provincia->departamento->nombre,
                ] : NULL,
                "tipo_site" => $this->site->tipo_site ? [
                    "id" => $this->site->tipo_site->id,
                    "nombre" => $this->site->tipo_site->nombre == 'POP' ?  $this->site->tipo_site->nombre : 'SITE',
                ] : NULL,
                "region_geografica" =>$this->site->region_geografica ? [
                    "id" => $this->site->region_geografica->id,
                    "nombre" => $this->site->region_geografica->nombre ,
                ] : NULL,
            ] : NULL,
            "cliente" => $this->cliente,
            "nombre_brigada" =>  $brigada->brigada->nombre ?? 'Sin Brigada',      
            "brigadas" => BrigadaResource::collection($this->brigadas),
            "tiempo_solucion" => $this->tiempo_solucion,
            "herramientas" => $this->herramientas,
            "causa_averia" => $this->causa_averia ? [
                "id" => $this->causa_averia->id,
                "nombre" => $this->causa_averia->nombre,
                "tipo_causa_averia" => $this->causa_averia->tipo_causa_averia ? [
                    "id" => $this->causa_averia->tipo_causa_averia->id,
                    "nombre" => $this->causa_averia->tipo_causa_averia->nombre
                ] : NULL
            ] : NULL,
            "consecuencia_averia" => $this->consecuencia_averia ? [
                "id" => $this->consecuencia_averia->id,
                "nombre" => $this->consecuencia_averia->nombre,
            ] : NULL,
            "tipo_reparacion" => $this->tipo_reparacion ? [
                "id" => $this->tipo_reparacion->id,
                "nombre" => $this->tipo_reparacion->nombre,
            ] : NULL,
            "atenciones" => BitacoraAtencionResource::collection($this->bitacora_atencion->sortByDesc('orden')),
            "demoras" => BitacoraDemoraResource::collection($this->bitacora_demora->sortBy('orden')),
            "afect_servicio" => $this->afect_servicio ? "Si":"No",
            "afect_masiva" =>  $this->afect_masiva ? "Si":"No"
        ];
    }
}
