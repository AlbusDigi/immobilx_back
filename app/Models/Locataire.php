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
        'etatCivil',
        'pieceIdentite',
    ];

    // Relation inverse un-à-un vers le modèle Utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}