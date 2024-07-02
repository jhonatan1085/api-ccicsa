<?php

namespace App\Http\Controllers\Admin\Brigada;

use App\Http\Controllers\Controller;
use App\Http\Resources\Brigada\BrigadaCollection;
use App\Models\Brigada\Brigada;
use App\Models\Brigada\BrigadaUser;
use App\Models\Brigada\TipoBrigada;
use App\Models\Site\Contratista;
use App\Models\Site\Zona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BrigadasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $brigadas = Brigada::BrigadaAll()->paginate(3);
        return response()->json([
            "total" => $brigadas->total(),
            "brigadas" => BrigadaCollection::make($brigadas)
        ]);
    }

    public function config()
    {
        $zonas = Zona::orderBy('nombre')->get();
        $contratistas = Contratista::orderBy('nombre')->get();
        $tipobrigadas = TipoBrigada::orderBy('nombre')->get();
        $users = User::all();
        return response()->json([
            "zonas" => $zonas,
            "contratistas" => $contratistas,
            "tipobrigadas" => $tipobrigadas,
            "users" =>$users
        ]);
    }

    public function brigadaactiva()
    {
        
        $brigadas = Brigada::BrigadaAll()->where('estado','1')->get();
        return response()->json([
            "brigadas" => BrigadaCollection::make($brigadas)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* $site_is_valid = Site::where("codigo", $request->codigo)->first();
        if ($site_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CODIGO DE SITE YA EXISTE"
            ]);
        } */

        $tecnicos = json_decode($request->tecnicos, 1);
       
        $request->request->add(["fecha_alta" => now()]);


        $brigada = Brigada::create($request->all());

                //agregar los tecnicos seleccionados
                foreach ($tecnicos as $key => $tecnico) {

                            BrigadaUser::create([
                                "user_id" => $tecnico["user_id"],
                                "brigada_id" => $brigada->id,
                                "unidad_movil_id" => $tecnico["movil_id"] ,
                                "is_lider" => $tecnico["is_lider"] ,
                            ]);
                       
                }

        return response()->json([
            "message" => 200
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
}
