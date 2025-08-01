<?php

namespace App\Http\Controllers\Admin\Inventario;

use App\Http\Controllers\Controller;
use App\Http\Resources\Inventario\ExistenciaCollection;
use App\Models\Inventario\Existencia;
use Illuminate\Http\Request;

class ExistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $existencias = Existencia::with('brigada', 'material') // <-- Cargamos relaciones
            ->whereHas('brigada', function ($q) use ($search) {
                $q->where('nombre', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas("material", function ($q) use ($search) {
                    $q->where("nombre", "like", "%" . $search . "%")
                    ->orwhere("codigo", "like", "%" . $search . "%");
                })
            ->paginate($request->get('perPage', 10));

        return response()->json([
            "total" => $existencias->total(),
            "data" => ExistenciaCollection::make($existencias)
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
}
