<?php

namespace App\Models\UnidadMovil;

use App\Models\Brigada\BrigadaUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMovil extends Model
{
    use HasFactory;
 
    protected $fillable = [
        "placa",
        "kilometraje",
        "modelo_id",
        "color_id",
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

    public function unidad_movil_user() 
    {
        return $this->hasMany(UnidadMovilUser::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class)
        ->withPivot('estado')
        ->where('estado','1');
    }

    public function brigada_user() 
    {
        return $this->hasMany(BrigadaUser::class);
    }

    public function modelo() 
    {
        return $this->belongsTo(Modelo::class);
    }

    public function color() 
    {
        return $this->belongsTo(Color::class);
    }

}
