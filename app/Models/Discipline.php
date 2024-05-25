<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $table = 'disciplines';

    protected $fillable = [
        'Discipline',
        'Etablissement',
        'Academie',
        'Region',
        'Type_diplome',
        'Nom_diplome',
        'Nbr_poursuivants',
        'Nbr_sortants',
        'Taux_emploi_salarié',
        'Date_insertion',
        'Taux_reussite',
        'Taux_insertion',
    ];
}