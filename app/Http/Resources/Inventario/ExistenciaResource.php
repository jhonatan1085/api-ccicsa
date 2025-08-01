<?php

namespace App\Http\Resources\Inventario;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExistenciaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        parent::wrap(null);
         return [
            "id" => $this->id,
            "brigada_id" => $this->brigada->id,
            "brigada_nombre" => $this->brigada->nombre,
            "material_id" => $this->material->id,
            "codigo" => $this->material->codigo,
            "nombre_material" => $this->material->nombre,
            "stock_actual" => $this->stock_actual,
            "subcategoria" => $this->material->subcategoria->nombre,
            "categoria" => $this->material->subcategoria->categoria->nombre,
        ];
    }
}
