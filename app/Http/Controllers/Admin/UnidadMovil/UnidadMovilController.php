<?php

namespace App\Http\Controllers\Admin\UnidadMovil;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnidadMovil\UnidadMovilCollection;
use App\Models\UnidadMovil\Color;
use App\Models\UnidadMovil\Marca;
use App\Models\UnidadMovil\Modelo;
use App\Models\UnidadMovil\UnidadMovil;
use Illuminate\Http\Request;

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
                ->paginate(10);
        
        return response()->json([
            "total" => $unidadesMoviles->total(),
            "data" => UnidadMovilCollection::make($unidadesMoviles)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $unidadmovil = UnidadMovil::create($request->all());

        return response()->json([
            "message" => 200, "message_text" => "ok"
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
