<?php

namespace App\Http\Controllers\Admin\UnidadMovil;

use App\Http\Controllers\Controller;
use App\Models\UnidadMovil\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

            $marcas = Marca::paginate(10);
        
        return response()->json([
            "total" => $marcas->total(),
            "data" => $marcas//BitacoraCollection::make($bitacoras)
        ]);
    }
        
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $user = Marca::create($request->all());

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
}
