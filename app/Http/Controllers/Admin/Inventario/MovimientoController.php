<?php

namespace App\Http\Controllers\Admin\Inventario;

use App\Http\Controllers\Controller;
use App\Models\Inventario\Existencia;
use App\Models\Inventario\Material;
use App\Models\Inventario\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $movimiento = Movimiento::paginate();

        return response()->json([
            "total" => $movimiento->total(),
            "data" => $movimiento //BitacoraCollection::make($bitacoras)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}





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

    public function agregaMateriales(Request $request)
    {

        try {

            $id = auth('api')->user()->id;

            $brigadaId = $request->materiales[0]['brigada_id'];




            $request->validate([
                'materiales' => 'required|array',
                'materiales.*.material_id' => 'required|exists:materiales,id',
                'materiales.*.brigada_id' => 'required|exists:brigadas,id',
                'materiales.*.cantidad' => 'required|numeric|min:0.01',
                'bitacora_id' => 'required|exists:bitacoras,id',
            ]);

            // 1. Obtener movimientos previos
            $movimientosPrevios = Movimiento::where('bitacora_id', $request->bitacora_id)
                ->where('brigada_id', $brigadaId)
                ->get();
            // 2. Revertir stock
            foreach ($movimientosPrevios as $mov) {
                $exist = Existencia::where('brigada_id', $mov->brigada_id)
                    ->where('material_id', $mov->material_id)
                    ->first();

                if ($exist) {
                    $exist->stock_actual += $mov->cantidad;
                    $exist->save();
                }

                $mov->delete(); // 3. Eliminar movimiento anterior
            }

            foreach ($request->materiales as $item) {
                // Verifica y actualiza el stock
                $existencia = Existencia::where('brigada_id', $item['brigada_id'])
                    ->where('material_id', $item['material_id'])
                    ->first();

                if (!$existencia || $existencia->stock_actual < $item['cantidad']) {


                    $materialNombre = Material::find($item['material_id'])?->nombre ?? 'desconocido';

                    return response()->json([
                        'message' => 403,
                        'message_text' => 'Stock insuficiente para el material ' .  $materialNombre,
                    ], 403);
                }

                $existencia->stock_actual -= $item['cantidad'];
                $existencia->save();

                // Registra movimiento
                $movimiento =  Movimiento::create([
                    'bitacora_id' => $request->bitacora_id,
                    'brigada_id' => $item['brigada_id'],
                    'material_id' => $item['material_id'],
                    'user_created_by' => $id,
                    'tipo' => 'salida',
                    'cantidad' => $item['cantidad'],
                    'fecha_movimiento' => now(),
                ]);
            }

            return response()->json([
                'message' => 200,
                'message_text' => 'Materiales registrados correctamente',
            ]);
        } catch (ValidationException $e) {
            // Errores de validación
            return response()->json([
                'message' => 422,
                'message_text' => $e->errors(),
            ],);
        } catch (Exception $e) {
            // Errores generales
            return response()->json([
                'message' => 500,
                'message_text' => $e->getMessage(),
            ]);
        }
    }
    
}
