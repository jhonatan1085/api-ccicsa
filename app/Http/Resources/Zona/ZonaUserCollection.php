<?php

namespace App\Http\Resources\Zona;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ZonaUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ZonaUserResource::collection($this->collection)->resolve();
    }
}
