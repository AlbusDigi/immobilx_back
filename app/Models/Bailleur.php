<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bailleur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rccm',
        'nif',
    ];

    // Relation inverse un-à-un vers le modèle Utilisateur
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}