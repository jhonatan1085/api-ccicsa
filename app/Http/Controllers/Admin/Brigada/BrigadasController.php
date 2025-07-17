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
            ->with('brigada_user_activos')
            ->whereHas('zona', function ($q) {
                $q->where('region_id',  auth('api')->user()->zona->region->id);
            })
            ->orderBy('fecha_alta', 'desc')->get();

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
            ->where('estado', '1')
            ->with('brigada_user_activos')
            ->get();
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
                'tecnicos' => 'required|array|min:1',
                'nombre' => 'required',

            ];
            $messages = [
                'zona_id.required' => 'Debe ingresar zona',
                'tipo_brigada_id.required' => 'Debe ingresar zona',
                'contratista_id.required' => 'Debe ingresar zona',
                'tecnicos.required' => 'No ingresó técnicos',
                'nombre.required' => 'No ingreso nombre',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    "error" => $validator->errors()
                ]);
            }


            $request->request->add(["fecha_alta" => now()]);

            $brigada = Brigada::create($request->all());

            //agregar los tecnicos seleccionados
            foreach ($request->tecnicos as $tecnico) {

                BrigadaUser::create([
                    "user_id" => $tecnico["user_id"],
                    "brigada_id" => $brigada->id,
                    "unidad_movil_id" => $tecnico["movil_id"],
                    "is_lider" => $tecnico["is_lider"],
                ]);
            }

            return response()->json([
                "message" => 200,
                "message_text" => "ok",
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
        try {
            $rules = [
                'tecnicos' => 'required|array|min:1',
            ];

            $messages = [
                'tecnicos.required' => 'No ingresó técnicos',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    "error" => $validator->errors()
                ]);
            }

            $brigada = Brigada::findOrFail($id);
            $nuevos = collect($request->tecnicos);

            // Obtener técnicos actualmente activos
            $existentes = BrigadaUser::where('brigada_id', $id)
                ->where('estado', true)
                ->get();

            // Dar de baja a los técnicos que ya no están en la nueva lista
            foreach ($existentes as $existente) {
                if (!$nuevos->contains('user_id', $existente->user_id)) {
                    $existente->update([
                        'estado' => false,
                        'fecha_baja' => now()
                    ]);
                }
            }

            // Agregar o actualizar técnicos nuevos
            foreach ($request->tecnicos as $tecnico) {
                // Verificar si ya existe un registro ACTIVO del técnico
                $registroActivo = BrigadaUser::where([
                    'brigada_id' => $id,
                    'user_id' => $tecnico['user_id'],
                    'estado' => true
                ])->first();

                if (!$registroActivo) {
                    // Verificar si existe uno anterior dado de baja
                    $registroAnterior = BrigadaUser::where([
                        'brigada_id' => $id,
                        'user_id' => $tecnico['user_id'],
                        'estado' => false
                    ])->orderBy('fecha_baja', 'desc')->first();

                    // Crear un nuevo ingreso
                    BrigadaUser::create([
                        'brigada_id' => $id,
                        'user_id' => $tecnico['user_id'],
                        'unidad_movil_id' => $tecnico['movil_id'],
                        'is_lider' => $tecnico['is_lider'],
                        'estado' => true,
                        'fecha_alta' => now(),
                        'fecha_baja' => null
                    ]);
                } else {
                    // Ya está activo, actualizamos sus datos (sin tocar fecha_alta)
                    $registroActivo->update([
                        'unidad_movil_id' => $tecnico['movil_id'],
                        'is_lider' => $tecnico['is_lider']
                    ]);
                }
            }

            return response()->json([
                'message' => 200,
                'message_text' => 'Técnicos actualizados correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 500,
                'error' => $e->getMessage()
            ]);
        }
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
            "message" => 200,
            "message_text" => "ok"
        ]);
    }

    public function config()
    {
        $zonas = Zona::orderBy('nombre')->where('region_id', auth('api')->user()->zona->region->id)->get();
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
