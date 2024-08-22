<?php

namespace App\Models\UnidadMovil;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "marca_id"
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
    public function unidad_movil() 
    {
        return $this->hasMany(UnidadMovil::class);
    }
    public function marca() 
    {
        return $this->belongsTo(Marca::class);
    }
}
