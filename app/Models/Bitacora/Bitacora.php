<?php

namespace App\Models\Bitacora;

use App\Models\Brigada\Brigada;
use App\Models\Site\Site;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "fecha_inicial",
        "sot",
        "insidencia",
        "tipo_averia_id",
        "latitud",
        "longitud",
        "distancia",
        "red_id",
        "serv_id",
        "site_id",
        "resp_cicsa_id",
        "resp_claro_id",
        "estado"
    ];

    public function setCreatedAtAttribute($value)
    {
    	date_default_timezone_set('America/Lima');
        $this->attributes["created_at"]= Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    public function resp_claro() 
    {
        return $this->belongsTo(User::class,"resp_claro_id");
    }

    public function resp_cicsa() 
    {
        return $this->belongsTo(User::class,"resp_cicsa_id");
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
    

    public function brigada()
    {
        return $this->belongsToMany(Brigada::class);
    }

    public function bitacora_atencion() 
    {
        return $this->hasMany(BitacoraAtencion::class)->whereNull('parent_id');
    }

    public function atencion()
    {
        return $this->belongsToMany(Atencion::class);
    }
}
