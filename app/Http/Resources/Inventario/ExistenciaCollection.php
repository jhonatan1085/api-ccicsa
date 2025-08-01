<?php

namespace App\Http\Resources\Inventario;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExistenciaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  ExistenciaResource::collection($this->collection)->resolve();
    }
}
