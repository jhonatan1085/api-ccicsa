<?php

namespace App\Http\Controllers\Admin\Bitacora;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bitacora\BitacoraCollection;
use App\Http\Resources\Bitacora\BitacoraResource;
use App\Models\Bitacora\Atencion;
use App\Models\Bitacora\Bitacora;
use App\Models\Bitacora\BitacoraAtencion;
use App\Models\Bitacora\BitacoraBrigada;
use App\Models\Bitacora\BitacoraDemora;
use App\Models\Bitacora\CausaAveria;
use App\Models\Bitacora\ConsecuenciaAveria;
use App\Models\Bitacora\Red;
use App\Models\Bitacora\Serv;
use App\Models\Bitacora\TipoAveria;
use App\Models\Bitacora\TipoDemora;
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
     *     tags={"Bitacoras"},
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

        if ($roles[0] == "Admin" || $roles[0] == "Held Desk") {
            $bitacoras = Bitacora::where('nombre', "like", "%" . $search . "%")
                ->orWhereHas("red", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhereHas("red", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%");
                })
                ->orWhere("incidencia", "like", "%" . $search . "%")
                ->orWhere("sot", "like", "%" . $search . "%")
                //->orderBy("fecha_inicial", "desc")
                ->orderBy("id", "desc")
                ->paginate(10);
            // dd($id );
        } else {
            $bitacoras = Bitacora::whereHas('brigadas.user', function ($q) use ($id) {
                $q->where('users.id',  $id);
            })
                ->where(function ($query) use ($search) {
                    $query->where('nombre', "like", "%" . $search . "%")
                        ->orWhere("incidencia", "like", "%" . $search . "%")
                        ->orWhere("sot", "like", "%" . $search . "%")
                        ->orWhereHas("red", function ($q) use ($search) {
                            $q->where("nombre", "like", "%" . $search . "%");
                        })
                        ->orWhereHas("red", function ($q) use ($search) {
                            $q->where("nombre", "like", "%" . $search . "%");
                        });
                })
                //->orderBy("fecha_inicial", "desc")
                ->orderBy("id", "desc")
                ->paginate(10);
            //dd($id );
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

    public function demorasConfig()
    {
        $tipoDemoras = TipoDemora::select('id', 'nombre')->orderBy('nombre')->get();
        
        return response()->json([
            "demoras" => $tipoDemoras
        ]);
    }

    public function listarDemoras(string $id)
    {
        $demoras = BitacoraDemora::where('bitacora_id', $id)
            ->orderBy('orden')->get();
        return response()->json([
            "total" => $demoras->count(),
            "data" => $demoras,
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
     * @OA\Post(
     *     path="/bitacoras",
     *     summary="Crear una nueva bitácora",
     *     description="Crea una nueva bitácora con los datos proporcionados en la solicitud.",
     *     operationId="storeBitacora",
     *     tags={"Bitacoras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "fecha_inicial", "tipo_averia_id", "red_id", "serv_id", "site_id", "resp_cicsa_id", "resp_claro_id", "brigadas"},
     *             @OA\Property(property="nombre", type="string", example="Bitácora 1"),
     *             @OA\Property(property="fecha_inicial", type="string", format="date-time", example="2024-08-22 15:00:00"),
     *             @OA\Property(property="tipo_averia_id", type="integer", example=1),
     *             @OA\Property(property="red_id", type="integer", example=2),
     *             @OA\Property(property="serv_id", type="integer", example=3),
     *             @OA\Property(property="site_id", type="integer", example=4),
     *             @OA\Property(property="resp_cicsa_id", type="integer", example=5),
     *             @OA\Property(property="resp_claro_id", type="integer", example=6),
     *             @OA\Property(property="brigadas", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1)
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bitácora creada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="integer", example=200),
     *             @OA\Property(property="message_text", type="string", example="ok"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bitacora")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Error de validación o excepción",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="integer", example=403),
     *             @OA\Property(property="message_text", type="object")
     *         )
     *     )
     * )
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
                "message_text" => $e
            ]);
        }
    }

    public function addAtencion(Request $request)
    {
        $atenciones = json_decode($request->atenciones, 1);
        $bitacora = Bitacora::findOrFail($request->id);
        foreach ($bitacora->bitacora_atencion as $key => $atencion) {
            BitacoraAtencion::where('parent_id', $atencion->id)->delete();
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

    public function addDemora(Request $request)
    {

        BitacoraDemora::where('bitacora_id', $request->id)->delete();

        /*  $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);
        $request->fecha_inicial = Carbon::parse($date_clean)->format("Y-m-d h:i:s"); */

        foreach ($request->demo as $item) {
          /*   $date_inicio = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $item["fecha_inicio"]);
            $item["fecha_inicio"] = Carbon::parse($date_inicio)->format("Y-m-d h:i:s");
            $date_fin = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $item["fecha_fin"]);
            $item["fecha_fin"] = Carbon::parse($date_fin)->format("Y-m-d h:i:s"); */
            BitacoraDemora::create([
                "bitacora_id" => $item["bitacora_id"],
                "tipo_demora_id" => $item["tipo_demora_id"],
                "fecha_inicio" => $item["fecha_inicio"],
                "fecha_fin" => $item["fecha_fin"],
                "orden" => $item["orden"],
            ]);
        }


        return response()->json([
            "message" => 200,
            "message_text" => "ok"
        ]);
    }
    /**
     * @OA\Get(
     *     path="/bitacoras/{id}",
     *     summary="Obtener una bitácora por ID",
     *     description="Devuelve los detalles de una bitácora específica por su ID.",
     *     operationId="showBitacora",
     *     tags={"Bitacoras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la bitácora",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la bitácora",
     *         @OA\JsonContent(ref="#/components/schemas/Bitacora")
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
    public function show(string $id)
    {
        $bitacora = Bitacora::findOrFail($id);
        return BitacoraResource::make($bitacora);
    }

    /**
     * @OA\Post(
     *     path="/bitacoras/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"Bitacoras"},
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
            'latitud' => 'required',
            'longitud' => 'required',
        ];
        $messages = [
            'latitud.required' => 'Latitud es requerida',
            'longitud.required' => 'Longitud es requerida',
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
     *     tags={"Bitacoras"},
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
