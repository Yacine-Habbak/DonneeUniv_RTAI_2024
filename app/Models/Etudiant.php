<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';

    protected $fillable = [
        'univ_id',
        'Effectif_2022',
        'Effectif_2021',
        'Effectif_2020',
        'Effectif_2019',
        'Effectif_2018',
        'Effectif_2017',
        'Effectif_2016',
        'Effectif_2015',
        'Effectif_2014',
        'Effectif_2013',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}