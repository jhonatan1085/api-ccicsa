<?php

namespace App\Models\Brigada;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBrigada extends Model
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
    public function brigada() 
    {
        return $this->hasMany(Brigada::class);
    }
}
