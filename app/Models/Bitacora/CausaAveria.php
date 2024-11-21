<?php

namespace App\Models\Bitacora;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CausaAveria extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre"
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
        return $this->hasMany(Bitacora::class);
    }

    
    public function tipo_causa_averia()
    {
        return $this->belongsTo(TipoCausaAveria::class);
    }
}
