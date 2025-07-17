<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {


        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();

        return response()->json($user, 201);
    }

    public function reg()
    {
        $this->authorize('create', User::class);

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();

        return response()->json($user, 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        $user = auth('api')->user();

        $permissions = auth('api')->user()->getAllPermissions()->map(function ($perm) {
            return $perm->name;
        });

        // Obtener la brigada activa del usuario (solo una)
        $brigada = $user->brigada_activa()->first();

        $brigadaInfo = null;

        if ($brigada) {
            $brigadaInfo = [
                'brigada_id' => $brigada->id,
                'brigada_nombre' => $brigada->nombre,
                /*'is_lider' => $brigada->pivot->is_lider ?? null,
                'unidad_movil_id' => $brigada->pivot->unidad_movil_id ?? null,*/
            ];
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            "user" => [
                "name" => auth('api')->user()->name,
                "surname" => auth('api')->user()->surname,
                "zona" => [
                    "id" => auth('api')->user()->zona->id,
                    "nombre" => auth('api')->user()->zona->nombre,
                ],
                "region" => [
                    "id" => auth('api')->user()->zona->region->id,
                    "nombre" => auth('api')->user()->zona->region->nombre,
                ],
                // "avatar" => auth('api')->user()->avatar,
                "email" => auth('api')->user()->email,
                "roles" => auth('api')->user()->getRoleNames(),
                "permissions" => $permissions,
                "whatsapp" => auth('api')->user()->nro_whatsapp,
                "brigada" => $brigadaInfo, // ← brigada activa sin zona
            ],
        ]);
    }
}
