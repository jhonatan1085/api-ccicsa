<?php

namespace App\Http\Controllers\Admin\Inventario;

use App\Http\Controllers\Controller;
use App\Models\Inventario\Existencia;
use App\Models\Inventario\Material;
use App\Models\Inventario\Movimiento;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $material = Material::paginate() ;

        return response()->json([
            "total" => $material->total(),
            "data" => $material //BitacoraCollection::make($bitacoras)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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


  public function autocomplete($almacen_id)
    {

        $existencias = Existencia::with('material')
        ->where('almacen_id', $almacen_id)
        ->get();

        $materiales = $existencias->map(function ($existencia) {
        return [
            'id' => $existencia->material->id,
            'codigo' => $existencia->material->codigo,
            'nombre' => $existencia->material->nombre,
            'unidad_medida' => $existencia->material->unidad_medida,
            'stock_actual' => $existencia->stock_actual,
        ];
    });

        // $sites = Site::get();
        return response()->json([
            "total" => $materiales->count(),
            "data" =>    $materiales
        ]);
    }

    public function obtenerMaterialesRegistrados(Request $request)
    {
        $request->validate([
            'bitacora_id' => 'required|exists:bitacoras,id',
            'almacen_id' => 'required|exists:almacenes,id',
        ]);

        $bitacoraId = $request->bitacora_id;
        $almacenId = $request->almacen_id;

        $movimientos = Movimiento::where('bitacora_id', $bitacoraId)
            ->where('almacen_id', $almacenId)
            ->where('tipo', 'salida')
            ->with('material') // relación con el modelo Material
            ->get()
            ->map(function ($mov) {
                return [
                    'cantidad' => $mov->cantidad,
                    'almacen_id' => $mov->almacen_id,
                    'material' => [
                        'id' => $mov->material->id,
                        'codigo' => $mov->material->codigo,
                        'nombre' => $mov->material->nombre,
                        'unidad_medida' => $mov->material->unidad_medida,
                        'stock_actual' => optional(
                            $mov->material->existencias->where('almacen_id', $mov->almacen_id)->first()
                        )->stock_actual ?? 0,
                    ],
                ];
            });

        return response()->json([
            'message' => 200,
            'message_text' => 'Materiales obtenidos correctamente',
            'data' => $movimientos,
        ]);
    }
}
