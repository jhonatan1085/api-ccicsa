<?php

namespace App\Http\Controllers\Admin\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\Site\SiteCollection;
use App\Http\Resources\Site\SiteResource;
use App\Models\Site\Consesionaria;
use App\Models\Site\Contratista;
use App\Models\Site\Departamento;
use App\Models\Site\Distrito;
use App\Models\Site\Municipalidade;
use App\Models\Site\PrioridadSite;
use App\Models\Site\Provincia;
use App\Models\Site\Region;
use App\Models\Site\RegionGeografica;
use App\Models\Site\RoomType;
use App\Models\Site\Site;
use App\Models\Site\TipoAcceso;
use App\Models\Site\TipoEnergia;
use App\Models\Site\TipoSite;
use App\Models\Site\Zona;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $sites = Site::where("codigo", "like", "%" . $search . "%")
            ->orWhere("nombre", "like", "%" . $search . "%")
            ->orWhereHas("zona",function($q) use($search){
                $q->where("nombre", "like", "%" . $search . "%");
            })
            ->orderBy("nombre", "asc")
            ->paginate(100);

        return response()->json([
            "total" => $sites->total(),
            "sites" => SiteCollection::make($sites)
        ]);
    }

    public function config()
    {
        $municipalidades = Municipalidade::orderBy('nombre')->get();
        $tiposites = TipoSite::all();
        $zonas = Zona::orderBy('nombre')->get();
        $regions = Region::all();
        $regionGeograficas = RegionGeografica::all();
        $consesionarias = Consesionaria::orderBy('nombre')->get();
        $roomtypes = RoomType::orderBy('nombre')->get();
        $contratistas = Contratista::orderBy('nombre')->get();
        $tipoAcceso = TipoAcceso::orderBy('nombre')->get();
        $prioridad = PrioridadSite::orderBy('nombre')->get();
        $tipoEnergia = TipoEnergia::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();
        $distritos = Distrito::orderBy('nombre')->get();
        $provincias = Provincia::orderBy('nombre')->get();

        return response()->json([
            "municipalidades" => $municipalidades,
            "tiposites" => $tiposites,
            "zonas" => $zonas,
            "regions" => $regions,
            "regionGeograficas" => $regionGeograficas,
            "consesionarias" => $consesionarias,
            "roomtypes" => $roomtypes,
            "contratistas" => $contratistas,
            "tipoAcceso" => $tipoAcceso,
            "prioridad" => $prioridad,
            "tipoEnergia" => $tipoEnergia,
            "departamentos" => $departamentos,
            "provincias" =>$provincias,
            "distritos" => $distritos,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $site_is_valid = Site::where("codigo", $request->codigo)->first();
        if ($site_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CODIGO DE SITE YA EXISTE"
            ]);
        }

        $site = Site::create($request->all());

        return response()->json([
            "message" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $site = Site::findOrFail($id);
        
        return response()->json([
            "site" => SiteResource::make($site)  
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

       // $users_is_valid = User::where("id","<>",$id)->where("email",$request->email)->first();

        $site_is_valid = Site::where("id","<>",$id)->where("codigo", $request->codigo)->first();
        if ($site_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CODIGO DE SITE YA EXISTE"
            ]);
        }
        $site = Site::findOrFail($id);
        $site->update($request->all());
        
        return response()->json([
            "message" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function provinciadep(string $id)
    {
        $provincias = Provincia::where("departamento_id", $id)
            ->orderBy("nombre", "asc")
            ->get();
        return response()->json([
            "provincias" => $provincias
        ]);
    }

    public function distritoprov(string $id)
    {
        $distritos = Distrito::where("provincia_id", $id)
            ->orderBy("nombre", "asc")
            ->get();
        return response()->json([
            "distritos" => $distritos
        ]);
    }

    public function sitesautocomplete(Request $request)
    {
        $search = $request->search;
 
        $sites = Site::with('region:id,nombre','distrito:id,nombre,provincia_id','distrito.provincia:id,nombre,departamento_id','distrito.provincia.departamento:id,nombre','zona:id,nombre' )
        ->select('id','nombre','codigo','latitud','longitud','region_id','distrito_id','zona_id')
           // ->where("nombre", "like", "%". $search."%")
            ->orderBy("nombre", "asc")
            //->take(10)
            ->get();
        return response()->json([
            "sites" =>  $sites
        ]);
    }
}
