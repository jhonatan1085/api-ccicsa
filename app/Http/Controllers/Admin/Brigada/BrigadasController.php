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
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrigadasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $brigadas = Brigada::BrigadaAll()
        
        ->whereHas('zona', function ($q) {
            $q->where('region_id',  auth('api')->user()->zona->region->id);
        })
        
        
        ->orderBy('fecha_alta','desc')->get();

        return response()->json([
            "total" => $brigadas->count(),
            "data" => BrigadaCollection::make($brigadas)
        ]);
    }


    public function activas()
    {
        $brigadas = Brigada::BrigadaAll()
        ->whereHas('zona', function ($q) {
            $q->where('region_id',  auth('api')->user()->zona->region->id);
        })
        ->where('estado', '1')->get();
        return response()->json([
            "total" => $brigadas->count(),
            "data" => BrigadaCollection::make($brigadas)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'zona_id' => 'required',
                'tipo_brigada_id' => 'required',
                'contratista_id' => 'required',
                'tecnicos' => 'required',
            ];
            $messages = [
                'zona_id.required' => 'Debe ingresar zona',
                'tipo_brigada_id.required' => 'Debe ingresar zona',
                'contratista_id.required' => 'Debe ingresar zona',
                'tecnicos.required' => 'No ingreso tecnicos',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    "error" => $validator->errors()
                ]);
            }

            $tecnicos = json_decode($request->tecnicos, 1);
            $request->request->add(["fecha_alta" => now()]);

            $brigada = Brigada::create($request->all());

            //agregar los tecnicos seleccionados
            foreach ($tecnicos as $key => $tecnico) {

                BrigadaUser::create([
                    "user_id" => $tecnico["user_id"],
                    "brigada_id" => $brigada->id,
                    "unidad_movil_id" => $tecnico["movil_id"],
                    "is_lider" => $tecnico["is_lider"],
                ]);
            }

            return response()->json([
                "message" => 200, "message_text"=>"ok",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "error" => $e
            ]);
        }
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
        $brigada = Brigada::findOrFail($id);
        $brigada->estado = '0';
        $brigada->fecha_baja =  now();
        $brigada->save();

        return response()->json([
            "message" => 200, "message_text"=>"ok"
        ]);
    }

     public function config()
    {
        $zonas = Zona::orderBy('nombre')->where('region_id',auth('api')->user()->zona->region->id)->get();
        $contratistas = Contratista::orderBy('nombre')->get();
        $tipobrigadas = TipoBrigada::orderBy('nombre')->get();
        $users = User::all();
        return response()->json([
            "zonas" => $zonas,
            "contratistas" => $contratistas,
            "tipobrigadas" => $tipobrigadas,
            "users" => $users
        ]);
    }

}
