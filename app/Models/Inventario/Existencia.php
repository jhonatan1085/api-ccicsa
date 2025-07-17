<?php

namespace App\Models\Inventario;

use App\Models\Brigada\Brigada;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{
    use HasFactory;

    protected $fillable = ['brigada_id', 'material_id', 'stock_actual'];

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

    public function brigada()
    {
        return $this->belongsTo(Brigada::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
