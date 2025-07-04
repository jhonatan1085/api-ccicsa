<?php

namespace App\Models\Site;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bitacora\whatsappGroup;

class Region extends Model
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

    public function site() 
    {
        return $this->hasMany(Site::class);
    }

    public function zona() 
    {
        return $this->hasMany(Zona::class);
    }

        public function whatsapp_group(){
        return $this->hasMany(whatsappGroup::class);
    }


 /*     public function users() 
    {
        return $this->hasManyThrough(User::class,Zona::class);
    }  */
}
