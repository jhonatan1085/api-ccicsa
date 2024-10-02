<?php

namespace App\Models\Bitacora;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraDemora extends Model
{
    use HasFactory;
    protected $table = "bitacora_demora";

    protected $fillable = [
        "bitacora_id",
        "tipo_demora_id",
        "fecha_inicio",
        "fecha_fin",
        "orden"
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

    public function bitacora() 
    {
        return $this->belongsTo(Bitacora::class);
    }
    public function tipo_demora()
    {
        return $this->belongsTo(TipoDemora::class);
    }

}
