<?php

namespace App\Models\Site;

use App\Models\Brigada\Brigada;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
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
    public function site() : HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function user() 
    {
        return $this->hasMany(User::class);
    }

    public function brigada() 
    {
        return $this->hasMany(Brigada::class);
    }

    public function user_zona()
    {
        return $this->belongsToMany(User::class)
                                    ->withPivot('estado')
                                    ->where('estado','1');
    }
}
