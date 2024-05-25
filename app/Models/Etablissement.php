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
        'Secteur',
        'url',
        'Etudiants_inscrits_2022',
        'Etudiants_inscrits_2021',
        'Etudiants_inscrits_2020',
        'Etudiants_inscrits_2019',
        'Etudiants_inscrits_2018',
        'Personnels_non_enseignant',
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

    public function enseignants()
    {
        return $this->hasMany(Enseignant::class, 'univ_id');
    }

    public function personnels()
    {
        return $this->hasMany(Personnel::class, 'univ_id');
    }
}