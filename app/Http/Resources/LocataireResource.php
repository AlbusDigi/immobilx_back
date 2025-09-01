<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocataireResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profession' => $this->profession,
            'marital_status' => $this->marital_status,
            'residence_address' => $this->residence_address,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'identity_document' => $this->identity_document,
            'document_issued_date' => $this->document_issued_date,
            'document_issued_by' => $this->document_issued_by,
            'emergency_phone' => $this->emergency_phone,
            'guarantor_name' => $this->guarantor_name,
            'guarantor_phone' => $this->guarantor_phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
