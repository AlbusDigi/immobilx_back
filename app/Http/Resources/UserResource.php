<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'created_at' => $this->created_at,
            'role' => $this->getRoleNames()->first(), // Récupère le rôle de Spatie

            // Charge conditionnellement les informations de profil spécifiques au rôle
            'locataire' => $this->when($this->hasRole('Locataire'), function () {
                return new LocataireResource($this->locataire);
            }),
            'bailleur' => $this->when($this->hasRole('Bailleur'), function () {
                return new BailleurResource($this->bailleur);
            }),
        ];
    }
}
