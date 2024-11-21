<?php

namespace App\Http\Resources\Bitacora;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BitacoraDemoraCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return BitacoraDemoraResource::collection($this->collection)->resolve();
    }
}
