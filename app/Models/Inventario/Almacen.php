<?php

namespace App\Models\Inventario;

use App\Models\Site\Zona;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
     protected $fillable = ['nombre', 'descripcion', 'zona_id'];

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

    public function existencias()
    {
        return $this->hasMany(Existencia::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

}
