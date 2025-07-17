<?php

namespace App\Models\Bitacora;

use Carbon\Carbon;
use App\Models\UnidadMovil\UnidadMovil;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraBrigadaUser extends Model
{
    use HasFactory;
    protected $table = 'bitacora_brigada_user';

    protected $fillable = [
        'bitacora_brigada_id',
        'user_id',
        'unidad_movil_id',
        'is_lider',
        'fecha_registro',
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

    // Relación con BitacoraBrigada
    public function bitacora_brigada()
    {
        return $this->belongsTo(BitacoraBrigada::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unidad_movil()
    {
        return $this->belongsTo(UnidadMovil::class);
    }
}
