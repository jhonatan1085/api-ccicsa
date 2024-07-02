<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Educacion;
use App\Models\Site\Zona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\search;

class StaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::where("name","like","%". $search ."%")
                ->orWhere("surname","like","%". $search ."%")
                ->orWhere("email","like","%". $search ."%")
                ->orderBy("id","desc")
                ->get();

                
                return response()->json([
                    "users" => UserCollection::make($users) 
                ]);
    }

    public function config(){
        $roles = Role::orderBy('name')->get();
        $educacions = Educacion::orderBy('nombre')->get();
        $zonas = Zona::orderBy('nombre')->get();
        return response()->json([
            "roles" => $roles,
            "educacions" => $educacions,
            "zonas" => $zonas
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users_is_valid = User::where("email",$request->email)->first();
        if( $users_is_valid){
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE MAIL YA EXISTE"
            ]);
        }

        if($request->hasFile("imagen")){
            $path = Storage::putFile("staffs",$request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if($request->password){
            $request->request->add(["password",bcrypt($request->password)]);   
        }

       // $request->request->add(["birth_date" => Carbon::parse($request->birth_date, 'GMT-0500')->format("Y-m-d h:i:s")]);
        
        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->birth_date);
 
        $request->request->add(["birth_date" => Carbon::parse($date_clean)->format("Y-m-d h:i:s")]);


        $user = User::create($request->all());

        $role = Role::findOrFail($request->role_id);

        $user->assignRole($role);
        
        return response()->json([
            "message" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            "user" => UserResource::make($user)  
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users_is_valid = User::where("id","<>",$id)->where("email",$request->email)->first();
        if( $users_is_valid){
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE MAIL YA EXISTE"
            ]);
        }

        $user = User::findOrFail($id);

        if($request->hasFile("imagen")){
            if($user->avatar){
                Storage::delete($user->avatar);
            }

            $path = Storage::putFile("staffs",$request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if($request->password){
            $request->request->add(["password",bcrypt($request->password)]);   
        }
        
        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->birth_date);
 
        $request->request->add(["birth_date" => Carbon::parse($date_clean)->format("Y-m-d h:i:s")]);

        $user->update($request->all());

        if($request->role_id != $user->roles()->first()->id){
            $role_old = Role::findOrFail($user->roles()->first()->id);
            $user->removeRole($role_old);
    
            $role_new = Role::findOrFail($request->role_id);
            $user->assignRole($role_new);
        }

        
        
        return response()->json([
            "message" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if($user->avatar){
            Storage::delete($user->avatar);
        }

        $user->delete();

        return response()->json([
            "message" => 200
        ]);
    }

    public function usuariozona(string $id)
    {
        $usuarios = User::with('unidad_movil:id,placa')
            ->select('name','surname','id')
            ->where("zona_id", $id)
            ->orderBy("name", "asc")
            ->get();
        return response()->json([
            "usuarios" =>  $usuarios
        ]);
    }
    
}
