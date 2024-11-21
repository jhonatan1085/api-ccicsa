<?php

namespace App\Http\Resources\Bitacora;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BitacorasExportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return BitacorasExportResource::collection($this->collection)->resolve();
    }
}
