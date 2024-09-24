<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Brigada\Brigada;
use App\Models\Brigada\BrigadaUser;
use App\Models\Site\Zona;
use App\Models\UnidadMovil\UnidadMovil;
use App\Models\UnidadMovil\UnidadMovilUser;
use App\Models\User\ZonaUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //
        'surname',
        'cel_corp',
        'cel_per',
        'dni',
        'birth_date',
        'gender',
        'address',
        'avatar',
        'educacion_id',
        'zona_id'
    ];


    public function educacion() 
    {
        return $this->belongsTo(Educacion::class);
    }

    public function zona() 
    {
        return $this->belongsTo(Zona::class);
    }

    public function brigada_user() 
    {
        return $this->hasMany(BrigadaUser::class);
    }

    public function brigada() 
    {
        return $this->belongsToMany(Brigada::class);
    }

    public function unidad_movil()
    {
        return $this->belongsToMany(UnidadMovil::class)
        ->withPivot('estado')
        ->where('unidad_movil_user.estado','1');
    }
    
    public function unidad_movil_user()
    {
        return $this->hasMany(UnidadMovilUser::class)->where('estado','1');
    }

    public function zona_user()
    {
        return $this->hasMany(ZonaUser::class)->where('estado','1');
    }

    public function zonas()
    {
        return $this->belongsToMany(Zona::class)
                                    ->withPivot('estado')
                                    ->where('estado','1');
                                    //->where('is_user','1');
    }

    protected function setNameAttribute($value){
        $this->attributes['name'] = ucfirst(strtolower($value));
    }
    protected function setSurnameAttribute($value){
        $this->attributes['surname'] = ucfirst(strtolower($value));
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
