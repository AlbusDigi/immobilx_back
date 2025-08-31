<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocataireResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'profession' => $this->profession,
            'etatCivil' => $this->etatCivil,
            'pieceIdentite' => $this->pieceIdentite,
        ];
    }
}