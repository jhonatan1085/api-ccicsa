<?php

namespace App\Models\Bitacora;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraAtencion extends Model
{
    use HasFactory;
    protected $table = "bitacora_atencion";

    protected $fillable = [
        "hora",
        "descripcion",
        "orden",
        "bitacora_id",
        "atencion_id",
        "parent_id"
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
    
    public function atencion() 
    {
        return $this->belongsTo(Atencion::class);
    }

    public function parent() 
    {
        return $this->belongsTo(BitacoraAtencion::class,'parent_id');
    }

    public function bitacora_atencion() 
    {
        return $this->hasMany(BitacoraAtencion::class,'parent_id');
    }




}
