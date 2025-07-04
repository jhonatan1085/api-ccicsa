<?php

namespace App\Http\Controllers\Admin\Inventario;

use App\Http\Controllers\Controller;
use App\Models\Inventario\Existencia;
use App\Models\Inventario\Material;
use App\Models\Inventario\Movimiento;
use Illuminate\Http\Request;

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
        $id = auth('api')->user()->id;

        $request->validate([
            'materiales' => 'required|array',
            'materiales.*.material_id' => 'required|exists:materiales,id',
            'materiales.*.almacen_id' => 'required|exists:almacenes,id',
            'materiales.*.cantidad' => 'required|numeric|min:0.01',
            'bitacora_id' => 'required|exists:users,id',
        ]);



        // 1. Obtener movimientos previos
        $movimientosPrevios = Movimiento::where('bitacora_id', $request->bitacora_id)->get();

        // 2. Revertir stock
        foreach ($movimientosPrevios as $mov) {
            $exist = Existencia::where('almacen_id', $mov->almacen_id)
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
            $existencia = Existencia::where('almacen_id', $item['almacen_id'])
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
                'almacen_id' => $item['almacen_id'],
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
    }

    
}
