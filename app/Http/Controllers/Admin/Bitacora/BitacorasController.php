<?php

namespace App\Http\Controllers\Admin\Bitacora;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bitacora\BitacoraCollection;
use App\Http\Resources\Bitacora\BitacoraResource;
use App\Models\Bitacora\Atencion;
use App\Models\Bitacora\Bitacora;
use App\Models\Bitacora\BitacoraAtencion;
use App\Models\Bitacora\BitacoraBrigada;
use App\Models\Bitacora\CausaAveria;
use App\Models\Bitacora\ConsecuenciaAveria;
use App\Models\Bitacora\Red;
use App\Models\Bitacora\Serv;
use App\Models\Bitacora\TipoAveria;
use App\Models\Bitacora\TipoReparacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Bitácoras",
 *     description="Endpoints relacionados con la gestión de bitácoras"
 * )
 */
class BitacorasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/bitacoras",
     *     security={{"bearerAuth":{}}},
     *     tags={"Bitácoras"},
     *     @OA\Response(
     *          response="200",
     *          description="Muestra una lista de bitacoras.")
     * )
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $roles = auth('api')->user()->getRoleNames();
        $id = auth('api')->user()->id;

        if ($roles[0] == "Admin") {
            $bitacoras = Bitacora::where('nombre', "like", "%" . $search . "%")
                ->orWhereHas("red", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhereHas("red", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhere("incidencia", "like", "%" . $search . "%")
                ->orWhere("sot", "like", "%" . $search . "%")
                ->orderBy("fecha_inicial", "desc")
                ->paginate(10);
        } else {
            $bitacoras = Bitacora::where('nombre', "like", "%" . $search . "%")
                ->whereHas('brigadas.user', function ($q) use ($id) {
                    $q->where('users.id',  $id);
                })
                ->orWhereHas("red", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhereHas("red", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhere("incidencia", "like", "%" . $search . "%")
                ->orWhere("sot", "like", "%" . $search . "%")
                ->orderBy("fecha_inicial", "desc")
                ->get(10);
        }

        return response()->json([
            "total" => $bitacoras->total(),
            "data" => BitacoraCollection::make($bitacoras)
        ]);
    }

    public function endConfig()
    {
        $causa = CausaAveria::select('id', 'nombre')->orderBy('nombre')->get();
        $consecuencia = ConsecuenciaAveria::select('id', 'nombre')->orderBy('nombre')->get();
        $tipoReparacion = TipoReparacion::select('id', 'nombre')->orderBy('nombre')->get();
        return response()->json([
            "causa" => $causa,
            "consecuencia" => $consecuencia,
            "tipoReparacion" => $tipoReparacion
        ]);
    }

    public function listarAtenciones(string $id)
    {
        $atenciones = Atencion::with(['bitacora_atencion' => function ($q) use ($id) {
            $q->select('id', 'hora', 'descripcion', 'orden', 'is_coment', 'atencion_id', 'bitacora_id', 'parent_id')
                ->with('bitacora_atencion:id,hora,descripcion,orden,is_coment,atencion_id,bitacora_id,parent_id')
                ->where('bitacora_id', $id)
                ->orderBy('orden');
        }])
            ->select('id', 'descripcion', 'orden')
            ->orderBy('orden')->get();
        return response()->json([
            "total" => $atenciones->count(),
            "data" => $atenciones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'nombre' => 'required',
                'fecha_inicial' => 'required',
                'tipo_averia_id' => 'required',
                'red_id' => 'required',
                'serv_id' => 'required',
                'site_id' => 'required',
                'resp_cicsa_id' => 'required',
                'resp_claro_id' => 'required',
                'brigadas' => 'required',
            ];
            $messages = [
                'nombre.required' => 'Nombre es requerido',
                'fecha_inicial.required' => 'Debe ingresar fecha',
                'tipo_averia_id.required' => 'No selecciono tipo Averia',
                'red_id.required' => 'No selecciono Red1',
                'serv_id.required' => 'No selecciono Serv1',
                'site_id.required' => 'No ingreso Site',
                'resp_cicsa_id.required' => 'No selecciono responsable Ccicsa',
                'resp_claro_id.required' => 'No selecciono responsable Claro',
                "brigadas.required" => 'No selecciono cuadrilla'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    'message_text' => $validator->errors()
                ]);
            }
            $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);
            $request["fecha_inicial"] = Carbon::parse($date_clean)->format("Y-m-d h:i:s");
            $bitacora = Bitacora::create($request->all());
            //agregar los tecnicos seleccionados
            foreach ($request->brigadas as $brigada) {
                BitacoraBrigada::create([
                    "brigada_id" => $brigada["id"],
                    "bitacora_id" => $bitacora->id
                ]);
            }
            return response()->json([
                "message" => 200,
                "message_text" => "ok",
                "data" =>  $bitacora
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "error" => $e
            ]);
        }
    }

    public function addAtencion(Request $request)
    {
        $atenciones = json_decode($request->atenciones, 1);
        $bitacora = Bitacora::findOrFail($request->id);
        foreach ($bitacora->bitacora_atencion as $key => $atencion) {
            $atencion->delete();
        }
        foreach ($atenciones as $atencion) {
            foreach ($atencion["bitacora_atencion"] as $bitAtencion) {
                $atencion = BitacoraAtencion::create(
                    [
                        "hora" => $bitAtencion["hora"],
                        "orden" => $bitAtencion["orden"],
                        "is_coment" => $bitAtencion["is_coment"],
                        "descripcion" => $bitAtencion["descripcion"],
                        "bitacora_id" => $bitAtencion["bitacora_id"],
                        "atencion_id" => $bitAtencion["atencion_id"],
                        "parent_id" =>  null,
                    ]
                );
                foreach ($bitAtencion["bitacora_atencion"] as $bitAtencionHijos) {
                    BitacoraAtencion::create(
                        [
                            "hora" => $bitAtencionHijos["hora"],
                            "orden" => $bitAtencionHijos["orden"],
                            "is_coment" => $bitAtencionHijos["is_coment"],
                            "descripcion" => $bitAtencionHijos["descripcion"],
                            "bitacora_id" => $bitAtencionHijos["bitacora_id"],
                            "atencion_id" => $bitAtencionHijos["atencion_id"],
                            "parent_id" => $atencion->id,
                        ]
                    );
                }
            }
        }

        return response()->json([
            "message" => 200,
            "message_text" => "ok",
            "data" => $atenciones
        ]);
    }

    /**
     * @OA\Get(
     *     path="/bitacoras/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Bitácoras"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la bitácora",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Muestra una bitácora específica."
     *     )
     * )
     */
    public function show(string $id)
    {
        $bitacora = Bitacora::findOrFail($id);
        return BitacoraResource::make($bitacora);
    }

    /**
     * @OA\Post(
     *     path="/bitacoras/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Bitácoras"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la bitácora",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Actualiza una bitácora."
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $bitacora = Bitacora::findOrFail($id);

        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);
        $request["fecha_inicial"] = Carbon::parse($date_clean)->format("Y-m-d h:i:s");

        /*  $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);

        $request->fecha_inicial = Carbon::parse($date_clean)->format("Y-m-d h:i:s"); */


        $bitacora->update($request->all());


        foreach ($bitacora->bitacora_brigada as $key => $brigada) {
            $brigada->delete();
        }

        foreach ($request->brigadas as $brigada) {
            BitacoraBrigada::create([
                "brigada_id" => $brigada["id"],
                "bitacora_id" => $bitacora->id
            ]);
        }

        return response()->json([
            "message" => 200,
            "message_text" => "ok"
        ]);
    }

    public function updateLocation(Request $request)
    {
        $rules = [
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ];
        $messages = [
            'latitud.required' => 'Causa es requerida',
            'longitud.required' => 'Consecuencia es requerida',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                "message" => 403,
                'message_text' => $validator->errors()
            ]);
        }
        $bitacora = Bitacora::findOrFail($request->id);
        $bitacora->latitud = $request->latitud;
        $bitacora->longitud = $request->longitud;
        $bitacora->distancia = $request->distancia;
        $bitacora->save();
        // Devolver una respuesta exitosa
        return response()->json([
            'message_text' => "ok",
            'message' => 200,
            'data' => $bitacora
        ]);
    }

    public function updateFinal(Request $request)
    {
        $rules = [
            'causa' => 'required|exists:causa_averias,id',
            'consecuencia' => 'required|exists:consecuencia_averias,id',
            'tipoReparacion' => 'required|exists:tipo_reparacions,id',
            'tiempo' => 'required',
        ];
        $messages = [
            'causa.required' => 'Causa es requerida',
            'consecuencia.required' => 'Consecuencia es requerida',
            'tipoReparacion.required' => 'Tipo de Reparacion es requerida',
            'tiempo.required' => 'Tiempo es requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                "message" => 403,
                'message_text' => $validator->errors()
            ]);
        }
        $bitacora = Bitacora::findOrFail($request->id);
        $bitacora->causa_averia_id = $request->causa;
        $bitacora->consecuencia_averia_id = $request->consecuencia;
        $bitacora->tipo_reparacion_id = $request->tipoReparacion;
        $bitacora->herramientas = $request->herramientas;
        $bitacora->tiempo_solucion = $request->tiempo;
        $bitacora->estado = "0";
        $bitacora->save();
        return response()->json([
            "message" => 200,
            "message_text" => "ok",
            "data" => $bitacora
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/bitacoras/{id}",
     *     summary="Eliminar una bitácora",
     *     description="Elimina una bitácora por su ID.",
     *     operationId="destroyBitacora",
     *     tags={"Bitácoras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la bitácora a eliminar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bitácora eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="integer", example=200),
     *             @OA\Property(property="message_text", type="string", example="ok")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bitácora no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="integer", example=404),
     *             @OA\Property(property="message_text", type="string", example="Bitácora no encontrada")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $bitacora = Bitacora::findOrFail($id);
        $bitacora->delete();
        return response()->json([
            "message" => 200,
            "message_text" => "ok"
        ]);
    }

    public function config()
    {

        $tipoaveria = TipoAveria::orderBy('nombre')->get();
        $red = Red::orderBy('nombre')->get();
        $serv = Serv::orderBy('nombre')->get();
        return response()->json([
            "tipoaveria" => $tipoaveria,
            "red" => $red,
            "serv" => $serv
        ]);
    }
}
