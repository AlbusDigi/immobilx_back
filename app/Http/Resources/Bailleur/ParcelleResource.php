<?php

namespace App\Http\Resources\Bailleur;

use App\Http\Resources\BailleurResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParcelleResource extends JsonResource
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
            'bailleur' => new BailleurResource($this->bailleur),
            'name' => $this->name,
            'address' => $this->address,
            'area' => $this->area,
            'internal_rules' => $this->internal_rules,
            'cadastral_number' => $this->cadastral_number,
            'land_title_number' => $this->land_title_number,
            'land_title_date' => $this->land_title_date,
            'legal_status' => $this->legal_status,
            'housing_units' => $this->housing_units,
            'floors' => $this->floors,
            'construction_year' => $this->construction_year,
            'urban_zone' => $this->urban_zone,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
