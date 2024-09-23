<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Educacion;
use App\Models\Site\Zona;
use App\Models\User;
use App\Models\User\ZonaUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\search;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$this->authorize('viewAny', User::class);

        $search = $request->search;
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", "like", "%Tecnico%")
            ->orWhere("name", "like", "%Held Desk%");
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
       // $this->authorize('create', User::class);

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

        return response()->json([
            "message" => 200,
            "message_text" => "ok"
        ]);
    }

    /**
     * Display the specified resource. (read)
     */
    public function show(string $id)
    {
       // $this->authorize('view', User::class);

        $user = User::findOrFail($id);

        return response()->json(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$this->authorize('update', User::class);
        $users_is_valid = User::where("id", "<>", $id)->where("email", $request->email)->first();
        if ($users_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE MAIL YA EXISTE"
            ]);
        }
        $users_is_valid = User::where("id", "<>", $id)->where("dni", $request->dni)->first();
        if ($users_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE DNI YA EXISTE"
            ]);
        }
        $user = User::findOrFail($id);

        if ($request->hasFile("avatar")) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            $path = Storage::putFile("usuarios", $request->file("avatar"));
            $request->avatar = $path;
        }

        if ($request->password) {
            $request->password = bcrypt($request->password);
        }

        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->birth_date);

        $request->request->add(["birth_date" => Carbon::parse($date_clean)->format("Y-m-d h:i:s")]);
        $user->update($request->all());

        if ($user->roles()->first() && $request->role_id != $user->roles()->first()->id) {
            $role_old = Role::findOrFail($user->roles()->first()->id);
            $user->removeRole($role_old);

            $role_new = Role::findOrFail($request->role_id);
            $user->assignRole($role_new);
        } else if (!$user->roles()->first()) {
            $role_new = Role::findOrFail($request->role_id);
            $user->assignRole($role_new);
        }
        return response()->json([
            "message" => 200,
            "message_text" => "ok",
            "data" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      //  $this->authorize('delete', User::class);

        $user = User::findOrFail($id);
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->delete();

        return response()->json([
            "message" => 200,
            "message_text" => "ok"
        ]);
    }

    ////////////////////////////////////////

    public function asignarZona(Request $request)
    {
        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);
        $request["fecha_alta"] = Carbon::parse($date_clean)->format("Y-m-d h:i:s");
        $zonaUser = ZonaUser::create($request->all());

        return response()->json([
            "message" => 200,
            "message_text" => "ok",
            "data" =>  $zonaUser
        ]);
    }

    public function config()
    {
        $roles = Role::orderBy('name')->where("name", "like", "%Tecnico%")->orWhere("name", "like", "%Held Desk%")->get();
        $educacions = Educacion::orderBy('nombre')->get();
        $zonas = Zona::orderBy('nombre')->get();
        return response()->json([
            "roles" => $roles,
            "educacions" => $educacions,
            "zonas" => $zonas
        ]);
    }

    public function usuariosTecnicosPorZona(string $zona_id)
    {
        $usuarios = User::with('unidad_movil:id,placa')
            ->select('name', 'surname', 'id')
            ->where("zona_id", $zona_id)
            ->whereHas("roles", function ($q) {
                $q->where("name", "like", "%Tecnico%");
            })
            ->orderBy("name", "asc")
            ->get();

        return response()->json([
            'total' => $usuarios->count(),
            'data' => $usuarios
        ]);
    }

    public function usuariosResponsablesPorZona()
    {
        return response()->json([
            "cicsa" =>  $this->usuariosPorZonaYTipo( "1"),
            "claro" =>  $this->usuariosPorZonaYTipo( "0"),
        ]);
    }
    ////////////////////////////////////////////////////////////////

    private function usuariosPorZonaYTipo(string $tipo)
    {

        return User::select('name', 'surname', 'id')
            ->whereHas("zona_user", function ($q) use ( $tipo) {
                $q->where('is_user', $tipo)
                //->where("zona_id", $zona_id)
                    ;
            })
            ->get();


    }
}
