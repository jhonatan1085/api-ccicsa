<?php

namespace App\Http\Controllers\Admin\Bitacora;

use App\Http\Controllers\Controller;
use App\Models\Bitacora\Red;
use App\Models\Bitacora\Serv;
use App\Models\Bitacora\TipoAveria;
use App\Models\Brigada\Brigada;
use Illuminate\Http\Request;

class BitacorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
