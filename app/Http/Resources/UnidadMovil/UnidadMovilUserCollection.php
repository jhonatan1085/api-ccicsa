<?php

namespace App\Http\Resources\UnidadMovil;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UnidadMovilUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  UnidadMovilUserResource::collection($this->collection)->resolve();
    }
}
