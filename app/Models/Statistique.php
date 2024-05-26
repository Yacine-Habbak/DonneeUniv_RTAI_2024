<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    use HasFactory;

    protected $table = 'statistiques';

    protected $fillable = [
        'univ_id',
        'annee',
        'Etudiants_inscrits',
        'Etudiants_inscrits_H',
        'Etudiants_inscrits_F',
        'Bac_Gen',
        'Bac_STMG',
        'Bac_Autre',
        'Bac_PRO',
        'Bac_Dispense',
        'Etudiants_mobilite',
        'Bac4',
        'Bac5',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}