<?php

namespace App\Models\Brigada;

use App\Models\UnidadMovil\UnidadMovil;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaUser extends Model
{
    use HasFactory;
    
    protected $table = "brigada_user";
    protected $fillable = [
        "is_lider",
        "user_id",
        "brigada_id",
        "unidad_movil_id"
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

    public function brigada() 
    {
        return $this->belongsTo(Brigada::class);
    }
    public function unidad_movil() 
    {
        return $this->belongsTo(UnidadMovil::class);
    }
}
