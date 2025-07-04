<?php

namespace App\Models\Inventario;

use App\Models\Bitacora\Bitacora;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'almacen_id',
        'material_id',
        'tipo',
        'cantidad',
        'fecha_movimiento',
        'motivo',
        'bitacora_id',
        'traslado_uuid',
        'user_created_by',
        'user_updated_by'
    ];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    
    public function bitacora()
    {
        return $this->belongsTo(Bitacora::class);
    }

    public function userCreatedBy()
    {
        return $this->belongsTo(User::class, 'user_created_by');
    }

}
