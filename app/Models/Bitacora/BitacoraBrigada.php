<?php

namespace App\Models\Bitacora;

use App\Models\Brigada\Brigada;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraBrigada extends Model
{
    use HasFactory;
    protected $fillable = [
        "brigada_id",
        "bitacora_id"
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
    public function brigada() 
    {
        return $this->belongsTo(Brigada::class);
    }
}
