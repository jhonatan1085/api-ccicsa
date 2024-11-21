<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

class BaseModel extends Model
{
    use HasFactory;
    
    protected static function boot(){
        parent::boot();

        static::creating(function ($model){
            $userId = self::getAuthenticatedUserId();
            if($userId){
                $model->user_created_by = $userId;
                $model->user_updated_by = $userId;
            }
        });

        static::updating(function ($model){
            $userId = self::getAuthenticatedUserId();
            if($userId){
                $model->user_updated_by = $userId;
            }
        });
    }

    private static function getAuthenticatedUserId() {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            return $user ? $user->id : null;
        }catch (\Exception $e) {
            // Manejar el caso donde no se pueda obtener el usuario
            return null;
        }
    }
}
