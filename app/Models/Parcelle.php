<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcelle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Référence du bailleur
        'bailleur_id',

        // Informations générales
        'name',               // Nom / désignation de la parcelle
        'address',            // Adresse complète
        'area',               // Superficie
        'internal_rules',     // Règlement intérieur

        // Informations légales / cadastrales
        'cadastral_number',   // Numéro cadastral
        'land_title_number',  // Numéro du titre foncier
        'land_title_date',    // Date du titre foncier
        'legal_status',       // Statut juridique (registered, customary, state)

        // Informations sur le bâti
        'housing_units',      // Nombre de logements
        'floors',             // Nombre d'étages
        'construction_year',  // Année de construction
        'urban_zone',         // Zone d'urbanisme (residential, commercial, industrial, mixed, agricultural, protected)

        //etat
        'state',
        // Divers
        'note',               // Observations ou notes diverses
    ];


    public  function bailleur()
    {
        return $this->belongsTo(Bailleur::class);
    }

    public function logements(){
        return $this->hasMany(Logement::class);
    }

}
