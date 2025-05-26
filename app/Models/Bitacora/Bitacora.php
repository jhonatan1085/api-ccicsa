<?php

namespace App\Models\Bitacora;

use App\Models\BaseModel;
use App\Models\Brigada\Brigada;
use App\Models\Site\Site;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Bitacora",
 *     description="Bitacora model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Nombre de la bitacora"),
 *     @OA\Property(property="fecha_inicial", type="string", format="date-time", example="2024-08-22 14:00:00"),
 *     @OA\Property(property="tipo_averia_id", type="integer", example=1),
 *     @OA\Property(property="latitud", type="string", example="-12.046374"),
 *     @OA\Property(property="longitud", type="string", example="-77.042793"),
 *     @OA\Property(property="distancia", type="string", example="10km"),
 *     @OA\Property(property="red_id", type="integer", example=1),
 *     @OA\Property(property="serv_id", type="integer", example=1),
 *     @OA\Property(property="site_id", type="integer", example=1),
 *     @OA\Property(property="cliente", type="string", example="Nombre del cliente"),
 *     @OA\Property(property="resp_cicsa_id", type="integer", example=1),
 *     @OA\Property(property="resp_claro_id", type="integer", example=1),
 *     @OA\Property(property="estado", type="string", example="Pendiente"),
 *     @OA\Property(property="causa_averia_id", type="integer", example=1),
 *     @OA\Property(property="consecuencia_averia_id", type="integer", example=1),
 *     @OA\Property(property="tipo_reparacion_id", type="integer", example=1),
 *     @OA\Property(property="herramientas", type="string", example="Llave inglesa, destornillador"),
 *     @OA\Property(property="tiempo_solucion", type="string", example="3 horas"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-22 14:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-22 14:30:00"),
 * )
 */
class Bitacora extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "enlace_plano_site",
        "fecha_inicial",
        "fecha_ejecucion",
        "sot",
        "fecha_sot",
        "estado_sot",
        "incidencia",
        "tipo_averia_id",
        "latitud",
        "longitud",
        "distancia",
        "red_id",
        "serv_id",
        "nro_tas",
        "nro_crq",
        "site_id",
        "cliente",
        "resp_cicsa_id",
        "resp_claro_id",
        "estado",
        "causa_averia_id",
        "consecuencia_averia_id",
        "tipo_reparacion_id",
        "herramientas",
        "tiempo_solucion",
        "afect_servicio",
        "afect_masiva",
    ];

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set('America/Lima');
        $this->attributes["created_at"] = Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function resp_claro()
    {
        return $this->belongsTo(User::class, "resp_claro_id");
    }

    public function resp_cicsa()
    {
        return $this->belongsTo(User::class, "resp_cicsa_id");
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function serv()
    {
        return $this->belongsTo(Serv::class);
    }

    public function red()
    {
        return $this->belongsTo(Red::class);
    }

    public function tipo_averia()
    {
        return $this->belongsTo(TipoAveria::class);
    }

    public function bitacora_brigada()
    {
        return $this->hasMany(BitacoraBrigada::class);
    }


    public function brigadas()
    {
        return $this->belongsToMany(Brigada::class);
    }

    public function bitacora_atencion()
    {
        return $this->hasMany(BitacoraAtencion::class)->whereNull('parent_id');
    }
    
    public function bitacora_demora() 
    {
        return $this->hasMany(BitacoraDemora::class);
    }

    public function atencion()
    {
        return $this->belongsToMany(Atencion::class);
    }

    public function causa_averia()
    {
        return $this->belongsTo(CausaAveria::class);
    }

    public function consecuencia_averia()
    {
        return $this->belongsTo(ConsecuenciaAveria::class);
    }

    public function tipo_reparacion()
    {
        return $this->belongsTo(TipoReparacion::class);
    }
}
