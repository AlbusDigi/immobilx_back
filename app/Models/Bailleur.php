<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bailleur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'rccm',
        'nif',
        'type',
        'address',
        'description',
        'legal_name',
        'head_office_address',
        'legal_form',
        'registration_date',
        'legal_contact',
        'property_insurance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parcelles()
    {
        return $this->hasMany(Parcelle::class);
    }
    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'bailleur_id');
    }


}
