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
        'Secteur',
        'Etudiants_inscrits',
        'Personnels_non_enseignant',
    ];
}
