<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'bailleur_id',
        'locataire_id',
        'logement_id',
        'dateDebut',
        'dateFin',
        'caution',
        'loyerMensuel',
    ];

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class, 'bailleur_id');
    }

    public function locataire()
    {
        return $this->belongsTo(Locataire::class, 'locataire_id');
    }

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }

}
