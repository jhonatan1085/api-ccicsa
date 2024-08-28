<?php

namespace App\Http\Controllers\Admin\Lideres;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Models\Educacion;
use App\Models\Site\Zona;
use App\Models\User;
use App\Models\User\ZonaUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class LideresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", "like", "%Lider%")
                ->orWhere("name", "like", "%Claro%");
        })
            ->where(function ($query) use ($search) {
                $query->where("name", "like", "%" . $search . "%")
                    ->orWhere("surname", "like", "%" . $search . "%")
                    ->orWhere("email", "like", "%" . $search . "%");
            })
            ->orderBy("id", "desc")
            ->get();
        return response()->json([
            "total" => $users->count(),
            "data" => UserCollection::make($users)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users_is_valid = User::where("email", $request->email)->first();
        if ($users_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE MAIL YA EXISTE"
            ]);
        }

        $users_is_valid = User::where("dni", $request->dni)->first();
        if ($users_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE DNI YA EXISTE"
            ]);
        }

        if ($request->hasFile("imagen")) {
            $path = Storage::putFile("staffs", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if ($request->password) {
            $request->request->add(["password", bcrypt($request->password)]);
        }

        // $request->request->add(["birth_date" => Carbon::parse($request->birth_date, 'GMT-0500')->format("Y-m-d h:i:s")]);

        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->birth_date);

        $request->request->add(["birth_date" => Carbon::parse($date_clean)->format("Y-m-d h:i:s")]);

        $user = User::create($request->all());

        $role = Role::findOrFail($request->role_id);

        $user->assignRole($role);
        $is_user = "1";
        if ($role->name == "Claro") {
            $is_user = "0";
        } 

        //agregar los tecnicos seleccionados
        foreach ($request->zonas as $zona) {
            ZonaUser::create([
                "is_user" => $is_user,
                "user_id" => $user->id,
                "zona_id" => $zona["id"],
                "tipo_planta_id" => "2",
                "fecha_alta" => now(),
            ]);
        }

        return response()->json([
            "message" => 200,
            "message_text" => "ok",
            "data" =>  $user
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function config()
    {
        $roles = Role::orderBy('name')->where("name", "like", "%Lider%")->orWhere("name", "like", "Claro")->get();
        $educacions = Educacion::orderBy('nombre')->get();
        $zonas = Zona::orderBy('nombre')->get();
        return response()->json([
            "roles" => $roles,
            "educacions" => $educacions,
            "zonas" => $zonas
        ]);
    }
}
