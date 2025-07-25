<?php

namespace App\Http\Resources\Inventario;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            "codigo" => $this->codigo,
            "codigoSAP" => $this->codigoSAP,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "codigoAX" => $this->codigoAX,
            "sub_categoria" => $this->subcategoria  ? [
                "id" =>$this->subcategoria->id,
                "nombre" =>$this->subcategoria->nombre,
                "categoria" => $this->subcategoria->categoria  ? [
                    "id" =>$this->subcategoria->categoria->id,
                    "nombre" =>$this->subcategoria->categoria->nombre ,
                ]: NULL,
            ]: NULL,
            "precio" => $this->precio,
            "unidad_medida" => $this->unidad_medida,
            "stock_minimo" => $this->stock_minimo,
        ];
    }
}
