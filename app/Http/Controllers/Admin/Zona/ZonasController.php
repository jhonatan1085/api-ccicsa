<?php

namespace App\Http\Controllers\Admin\Zona;

use App\Http\Controllers\Controller;
use App\Models\Site\Zona;
use Illuminate\Http\Request;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $zonas = Zona::paginate(10);

        return response()->json([
            "total" => $zonas->total(),
            "data" => $zonas //BitacoraCollection::make($bitacoras)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $zona = Zona::create($request->all());

        return response()->json([
            "message" => 200, 
            "message_text" => "ok",
            "data" =>  $zona
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
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
