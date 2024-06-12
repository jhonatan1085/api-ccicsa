<?php

namespace App\Models\Site;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Site extends Model
{
    use HasFactory;
    protected $fillable = [
        "codigo",
        "nombre",
        "suministro",
        "latitud",
        "longitud",
        "direccion",
        "tiempo_sla",
        "autonomia_bts",
        "autonomia_tx",
        "tiempo_auto",
        "tiempo_caminata",
        "tiempo_acceso",
        "tipo_site_id",
        "zona_id",
        "region_geografica_id",
        "consesionaria_id",
        "distrito_id",
        "room_type_id",
        "contratista_id",
        "tipo_acceso_id",
        "prioridad_site_id",
        "municipalidade_id",
        "tipo_energia_id",
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
    
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
    public function tipo_site()
    {
        return $this->belongsTo(TipoSite::class);
    }

    public function region() 
    {
        return $this->belongsTo(Region::class);
    }
    public function region_geografica() 
    {
        return $this->belongsTo(RegionGeografica::class);
    }
    public function consesionaria() 
    {
        return $this->belongsTo(Consesionaria::class);
    }
    public function room_type() 
    {
        return $this->belongsTo(RoomType::class);
    }
    public function contratista() 
    {
        return $this->belongsTo(Contratista::class);
    }
    public function tipo_acceso() 
    {
        return $this->belongsTo(TipoAcceso::class);
    }
    public function prioridad_site() 
    {
        return $this->belongsTo(PrioridadSite::class);
    }
    public function municipalidade() 
    {
        return $this->belongsTo(Municipalidade::class);
    }
    public function tipo_energia() 
    {
        return $this->belongsTo(TipoEnergia::class);
    }
    public function distrito() 
    {
        return $this->belongsTo(Distrito::class);
    }


}
