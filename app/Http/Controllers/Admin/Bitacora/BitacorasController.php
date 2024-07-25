<?php

namespace App\Http\Controllers\Admin\Bitacora;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bitacora\BitacoraCollection;
use App\Http\Resources\Bitacora\BitacoraListCollection;
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
use App\Models\Brigada\Brigada;
use App\Models\Site\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;
class BitacorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $bitacoras = Bitacora::where('nombre', "like", "%" . $search . "%")
            ->orWhereHas("red", function ($q) use ($search) {
                $q->where("nombre", "like", "%" . $search . "%");
            })
            ->orWhereHas("red", function ($q) use ($search) {
                $q->where("nombre", "like", "%" . $search . "%");
            })
            ->orWhere("insidencia", "like", "%" . $search . "%")
            ->orWhere("sot", "like", "%" . $search . "%")
            ->orderBy("fecha_inicial", "desc")
            ->paginate(100);

        return response()->json([
            "total" => $bitacoras->total(),
            "bitacoras" => BitacoraListCollection::make($bitacoras)
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

    public function endConfig()
    {
        $causa = CausaAveria::select('id','nombre')->orderBy('nombre')->get();
        $consecuencia = ConsecuenciaAveria::select('id','nombre')->orderBy('nombre')->get();
        $tipoReparacion = TipoReparacion::select('id','nombre')->orderBy('nombre')->get();

        return response()->json([
            "causa" => $causa,
            "consecuencia" => $consecuencia,
            "tipoReparacion" => $tipoReparacion
        ]);
    }

    public function listAtencion(string $id)
    {
        $atencions = Atencion::with(['bitacora_atencion' => function ($q) use ($id) {
            $q->select('id', 'hora', 'descripcion', 'orden','is_coment', 'atencion_id', 'bitacora_id', 'parent_id')
                ->with('bitacora_atencion:id,hora,descripcion,orden,is_coment,atencion_id,bitacora_id,parent_id')
                ->where('bitacora_id', $id)
                ->orderBy('orden');
        }])
            ->select('id', 'descripcion', 'orden')
            ->orderBy('orden')->get();

       // return $atencions;
         return $atencions;
         
    }

    public function viewBitacora(string $id)
    {
        $bitacora = Bitacora::findOrFail($id);
        return  BitacoraResource::make($bitacora);
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();
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
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    "error" => $validator->errors()
                ]);
            }

            /* if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            } */

            $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->fecha_inicial);

            $request->request->add(["fecha_inicial" => Carbon::parse($date_clean)->format("Y-m-d h:i:s")]);


            $cuadrillas = json_decode($request->cuadrilla, 1);

            $bitacora = Bitacora::create($request->all());

            //agregar los tecnicos seleccionados
            foreach ($cuadrillas as $key => $cuadrilla) {

                BitacoraBrigada::create([
                    "brigada_id" => $cuadrilla["cuadrilla_id"],
                    "bitacora_id" => $bitacora->id
                ]);
            }

            return response()->json([
                "message" => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "error" => $e
            ]);
        }
    }



    public function addAtencionBitacora(Request $request)
    {
        try {


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
                "message" => $atenciones,
                // "retorno" => $cuadrillas
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "error" => $e
            ]);
        }
    }

    

    public function endBitacora(Request $request)
    {
        try {

            $bitacora = Bitacora::findOrFail($request->id);
            
            $bitacora->causa_averia_id = $request->causa;
            $bitacora->consecuencia_averia_id = $request->consecuencia;
            $bitacora->tipo_reparacion_id = $request->tipoReparacion;
            $bitacora->herramientas = $request->herramientas;
            $bitacora->tiempo_solucion = $request->tiempo;
            $bitacora->estado = "0";

            
            $bitacora->save();

            return response()->json([
                "message" => 200
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
        //
    }
}
