<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logement extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        'parcelle_id',         // lien avec la parcelle
        'name',                // nom du logement
        'floor',               // étage
        'rooms',               // nombre de pièces
        'living_area',         // surface habitable
        'construction_year',   // année de construction
        'equipments',          // équipements du logement
        'rent',                // loyer
        'charges',             // charges locatives
        'deposit',             // dépôt de garantie
        'availability',        // disponible / occupé / maintenance
        'state',              // actif / bloqué / pending
        'internal_rules',      // règles propres au logement
        'note',                // notes propres au logement
    ];

    public function parcelle()
    {
        return $this->belongsTo(Parcelle::class);
    }

}
