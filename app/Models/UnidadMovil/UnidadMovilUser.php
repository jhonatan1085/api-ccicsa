<?php

namespace App\Models\UnidadMovil;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMovilUser extends Model
{
    use HasFactory;
    protected $table = "unidad_movil_user";

    protected $fillable = [
        "fecha_alta",
        "fecha_baja",
        "km_inicial",
        "km_final",
        "estado",
        "user_id",
        "unidad_movil_id",
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
    
    public function unidad_movil() 
    {
        return $this->belongsTo(UnidadMovil::class);
    }
}
