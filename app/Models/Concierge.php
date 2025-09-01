<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concierge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'residence_address',
        'managed_housing_count',
        'salary',
        'hire_date',
        'contract_end_date',
        'social_security_number',
        'contract_type',
        'employment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
