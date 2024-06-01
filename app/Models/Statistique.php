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
        'Rentree',
        'Etudiants_inscrits',
        'Etudiants_inscrits_H',
        'Etudiants_inscrits_F',
        'Bac_Gen',
        'Bac_STMG',
        'Bac_Autre',
        'Bac_PRO',
        'Bac_Dispense',
        'Avance_bac',
        'Alheure_bac',
        'Retard_bac',
        'G_Droit',
        'G_Lettre_langues',
        'G_Science_inge',
        'G_STAPS',
        'Science_eco',
        'lettre_science',
        'Langue',
        'Science_hu',
        'Science_vie',
        'Science_Fo',
        'Etudiants_mobilite',
        'Bac4',
        'Bac5',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}