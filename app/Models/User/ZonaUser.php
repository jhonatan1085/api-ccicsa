<?php

namespace App\Models\User;

use App\Models\Site\Zona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaUser extends Model
{
    use HasFactory;

    protected $table = "zona_user";
    protected $fillable = [
        "is_user",
        "user_id",
        "zona_id",
        "tipo_planta_id",
        "fecha_alta",
        "fecha_baja",
        "estado",
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

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function zona() 
    {
        return $this->belongsTo(Zona::class);
    }
    public function tipo_planta() 
    {
        return $this->belongsTo(TipoPlanta::class);
    }
}
