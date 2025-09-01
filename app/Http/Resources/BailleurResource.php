<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BailleurResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rccm' => $this->rccm,
            'nif' => $this->nif,
            'type' => $this->type,
            'address' => $this->address,
            'description' => $this->description,
            'legal_name' => $this->legal_name,
            'head_office_address' => $this->head_office_address,
            'legal_form' => $this->legal_form,
            'registration_date' => $this->registration_date,
            'legal_contact' => $this->legal_contact,
            'property_insurance' => $this->property_insurance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}