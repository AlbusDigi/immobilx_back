<?php

namespace App\Http\Resources;

use App\Http\Resources\Bailleur\LogementResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin,
            'caution' => $this->caution,
            'loyerMensuel' => $this->loyerMensuel,
            'bailleur' => new BailleurResource($this->whenLoaded('bailleur')),
            'locataire' => new LocataireResource($this->whenLoaded('locataire')),
            'logement' => new LogementResource($this->whenLoaded('logement')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
