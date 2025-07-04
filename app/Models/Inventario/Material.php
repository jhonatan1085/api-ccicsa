<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = "materiales";
    
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'unidad_medida', 'stock_minimo'];

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
}
