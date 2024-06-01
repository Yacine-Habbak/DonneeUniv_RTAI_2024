<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;

    protected $table = 'etablissements';

    protected $fillable = [
        'Etablissement',
        'Type',
        'Commune',
        'Departement',
        'Region',
        'Academie',
        'Adresse',
        'Lon',
        'Lat',
        'Secteur',
        'url',
        'Personnels_non_enseignant',
        'Personnels_non_enseignant_H',
        'Personnels_non_enseignant_F',
        'Enseignants',
        'TE_Total',
        'TE_enseignants',
        'siret',
        'date_creation',
        'contact',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'Wikipedia',
    ];

    public function disciplines()
    {
        return $this->hasMany(Discipline::class, 'univ_id');
    }

    public function etudiants()
    {
        return $this->hasOne(Etudiant::class, 'univ_id');
    }

    public function diplomes()
    {
        return $this->hasMany(Diplome::class, 'univ_id');
    }

    public function enseignants()
    {
        return $this->hasMany(Enseignant::class, 'univ_id');
    }

    public function personnels()
    {
        return $this->hasMany(Personnel::class, 'univ_id');
    }

    public function statistiques()
    {
        return $this->hasMany(Statistique::class, 'univ_id');
    }
}