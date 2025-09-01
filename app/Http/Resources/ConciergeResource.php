<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConciergeResource extends JsonResource
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
            'residence_address' => $this->residence_address,
            'managed_housing_count' => $this->managed_housing_count,
            'salary' => $this->salary,
            'hire_date' => $this->hire_date,
            'contract_end_date' => $this->contract_end_date,
            'social_security_number' => $this->social_security_number,
            'contract_type' => $this->contract_type,
            'employment_status' => $this->employment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
