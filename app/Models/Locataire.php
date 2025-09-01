<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locataire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profession',
        'marital_status',
        'residence_address',
        'date_of_birth',
        'place_of_birth',
        'identity_document',
        'document_issued_date',
        'document_issued_by',
        'emergency_phone',
        'guarantor_name',
        'guarantor_phone',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}