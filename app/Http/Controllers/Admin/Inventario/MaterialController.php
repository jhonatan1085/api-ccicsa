<?php

namespace App\Http\Controllers\Admin\Inventario;

use App\Http\Controllers\Controller;
use App\Http\Resources\Inventario\MaterialCollection;
use App\Models\Inventario\Existencia;
use App\Models\Inventario\Material;
use App\Models\Inventario\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $material = Material::with('subcategoria.categoria') // <-- Cargamos relaciones
            ->where('nombre', "like", "%" . $search . "%")
             ->orWhere("codigo", "like", "%" . $search . "%")
             ->paginate($request->get('perPage', 10));


        return response()->json([
            "total" => $material->total(),
            "data" => MaterialCollection::make($material)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $rules = [
                'codigo' => 'required|unique:materiales,codigo',
                'nombre' => 'required',
                'sub_categoria_id' => 'required',
                'precio' => 'required',
                'unidad_medida' => 'required',
                'stock_minimo' => 'required',

            ];
            $messages = [
                'codigo.required' => 'Codigo Requerido',
                'codigo.unique' => 'El código de material ya existe',
                'nombre.required' => 'Nombre Requerido',
                'sub_categoria_id.required' => 'DSub Categoria Requerido',
                'precio.required' => 'Precio Requerido',
                'unidad_medida.required' => 'UM Requerido',
                'stock_minimo.required' => 'Stock Minimo Requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    "errors" => $validator->errors()  // <-- asegúrate que es 'errors' y no 'error'
                ], 422); // <-- este código también ayuda a Angular a reconocerlo como error de validación
            }

            $material =   Material::create($request->all());

            return response()->json([
                "message" => 200,
                "message_text" => "ok",
                "data" => $material
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "error" => $e->getMessage()
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
                'codigo' => 'required|unique:materiales,codigo,' . $id,
                'nombre' => 'required',
                'sub_categoria_id' => 'required',
                'precio' => 'required',
                'unidad_medida' => 'required',
                'stock_minimo' => 'required',

            ];
            $messages = [
                'codigo.required' => 'Codigo Requerido',
                'codigo.unique' => 'El código ya está registrado',
                'nombre.required' => 'Nombre Requerido',
                'sub_categoria_id.required' => 'DSub Categoria Requerido',
                'precio.required' => 'Precio Requerido',
                'unidad_medida.required' => 'UM Requerido',
                'stock_minimo.required' => 'Stock Minimo Requerido',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    "message" => 403,
                    "error" => $validator->errors()
                ]);
            }

            $material = Material::findOrFail($id);
            // Forzar a que el código nunca se actualice
            $requestData = $request->except('codigo'); // ignora código

            $material->update($requestData);

            return response()->json([
                "message" => 200,
                "message_text" => "ok",
                "data" => $material
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => 403,
                "error" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function autocomplete($brigada_id)
    {

        $existencias = Existencia::with('material')
            ->where('brigada_id', $brigada_id)
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
            'brigada_id' => 'required|exists:brigadas,id',
        ]);

        $bitacoraId = $request->bitacora_id;
        $brigadaId = $request->brigada_id;

        $movimientos = Movimiento::where('bitacora_id', $bitacoraId)
            ->where('brigada_id', $brigadaId)
            ->where('tipo', 'salida')
            ->with('material') // relación con el modelo Material
            ->get()
            ->map(function ($mov) {
                return [
                    'cantidad' => $mov->cantidad,
                    'brigada_id' => $mov->brigada_id,
                    'material' => [
                        'id' => $mov->material->id,
                        'codigo' => $mov->material->codigo,
                        'nombre' => $mov->material->nombre,
                        'unidad_medida' => $mov->material->unidad_medida,
                        'stock_actual' => optional(
                            $mov->material->existencias->where('brigada_id', $mov->brigada_id)->first()
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

    public function cargaMasiva(Request $request)
    {
        $materiales = $request->all(); // array de materiales

        foreach ($materiales as $item) {
            Material::updateOrCreate(
                ['codigo' => $item['codigo']],
                [
                    'codigoSAP' => $item['codigoSAP'] ?? null,
                    'nombre' => $item['nombre'],
                    'descripcion' => $item['descripcion'] ?? null,
                    'codigoAX' => $item['codigoAX'] ?? null,
                    'sub_categoria_id' => $item['sub_categoria_id'],
                    'precio' => $item['precio'],
                    'unidad_medida' => $item['unidad_medida'],
                    'stock_minimo' => $item['stock_minimo'],
                ]
            );
        }

        return response()->json(['message' => 200, 'message_text' => 'Carga masiva exitosa']);
    }
}
