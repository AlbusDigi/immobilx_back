<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BailleurResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'rccm' => $this->rccm,
            'nif' => $this->nif,
        ];
    }
}