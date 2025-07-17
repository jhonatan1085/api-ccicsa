<?php

namespace App\Models\Brigada;

use App\Models\Bitacora\Bitacora;
use App\Models\Bitacora\BitacoraBrigada;
use App\Models\Inventario\Existencia;
use App\Models\Inventario\Movimiento;
use App\Models\Site\Contratista;
use App\Models\Site\Zona;
use App\Models\UnidadMovil\UnidadMovil;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brigada extends Model
{
    use HasFactory;

    protected $fillable = [
        "zona_id",
        "tipo_brigada_id",
        "contratista_id",
        "nombre",
        "fecha_alta",
        "fecha_baja",
        "estado",
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

    public function setFechaAltaAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["fecha_alta"] = Carbon::now();
    }

    public function tipo_brigada()
    {
        return $this->belongsTo(TipoBrigada::class);
    }


    public function contratista()
    {
        return $this->belongsTo(Contratista::class);
    }
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
    public function brigada_user()
    {
        return $this->hasMany(BrigadaUser::class);
    }

    public function bitacora_brigada()
    {
        return $this->hasMany(BitacoraBrigada::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function unidad_movil()
    {
        return $this->belongsToMany(UnidadMovil::class);
    }

    public function bitacora()
    {
        return $this->belongsToMany(Bitacora::class);
    }

    public function existencias()
    {
        return $this->hasMany(Existencia::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function scopeBrigadaAll($query)
    {
        return $query->with('contratista', 'zona', 'tipo_brigada', 'user.unidad_movil');
    }

    public function scopeBrigadaActiva($query)
    {
        return $query->where("estado", "1")
            ->with('contratista', 'zona', 'tipo_brigada', 'user.unidad_movil');
    }

    public function scopeBrigadaBitacora($query)
    {
        return $query->with('user.unidad_movil', 'user')->where('');
    }

    public function brigada_user_activos()
    {
        return $this->hasMany(BrigadaUser::class)->where('estado', true);
    }
}
