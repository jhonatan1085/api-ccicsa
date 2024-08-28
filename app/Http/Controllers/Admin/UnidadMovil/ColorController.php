<?php

namespace App\Http\Controllers\Admin\UnidadMovil;

use App\Http\Controllers\Controller;
use App\Models\UnidadMovil\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $colores = Color::paginate() ;

        return response()->json([
            "total" => $colores->total(),
            "data" => $colores //BitacoraCollection::make($bitacoras)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $color = Color::create($request->all());

        return response()->json([
            "message" => 200,
            "message_text" => "ok",
            "data" =>  $color
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
