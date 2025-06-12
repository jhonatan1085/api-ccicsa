<?php

namespace App\Models\Bitacora;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Site\Region;
class whatsappGroup extends Model
{
    use HasFactory;
        protected $fillable = [
        "group_name",
        "tipo_averia_id",
        "region_id"
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

        public function tipo_averia()
    {
        return $this->belongsTo(TipoAveria::class);
    }

        public function region() 
    {
        return $this->belongsTo(Region::class);
    }

}
