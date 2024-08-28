<?php

namespace App\Http\Controllers\Admin\UnidadMovil;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnidadMovil\UnidadMovilCollection;
use App\Models\UnidadMovil\Color;
use App\Models\UnidadMovil\Marca;
use App\Models\UnidadMovil\Modelo;
use App\Models\UnidadMovil\UnidadMovil;
use App\Models\UnidadMovil\UnidadMovilUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class UnidadMovilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

            $unidadesMoviles = UnidadMovil::where('placa', "like", "%" . $search . "%")
                ->orWhereHas("modelo.marca", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhereHas("modelo", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orderBy('placa','asc')
                ->orderBy('estado','desc')
                ->get();
        
        return response()->json([
            "total" => $unidadesMoviles->count(),
            "data" => UnidadMovilCollection::make($unidadesMoviles)
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'placa' => 'required',
                'kilometraje' => 'required',
                'modelo_id' => 'required',
                'color_id' => 'required'
            ];
            $messages = [
                'placa.required' => 'placa es requerida',
                'kilometraje.required' => 'Debe ingresar kilometraje',
                'modelo_id.required' => 'No selecciono modelo',
                'color_id.required' => 'No selecciono color'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    'message_text' => $validator->errors()
                ]);
            }
            $unidadmovil = UnidadMovil::create($request->all());

        return response()->json([
            "message" => 200, 
            "message_text" => "ok",
            "data" =>  $unidadmovil
        ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "message_text" => $e
            ]);
        }


        
    }


    //Asignacion de unidades moviles
    public function asignar(Request $request)
    {
        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);
        $request["fecha_alta"] = Carbon::parse($date_clean)->format("Y-m-d h:i:s");
        $unidadmovilUser = UnidadMovilUser::create($request->all());

        return response()->json([
            "message" => 200, 
            "message_text" => "ok",
            "data" =>  $unidadmovilUser
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
        $colores = Color::orderBy('nombre')->get();
        $marcas = Marca::orderBy('nombre')->get();
        $modelos = Modelo::orderBy('nombre')->get();
        return response()->json([
            "colores" => $colores,
            "marcas" => $marcas,
            "modelos" => $modelos
        ]);
    }
}
