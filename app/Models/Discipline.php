<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $table = 'disciplines';

    protected $fillable = [
        'univ_id',
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

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}