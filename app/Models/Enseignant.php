<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $table = 'enseignants';

    protected $fillable = [
        'univ_id',
        'Etablissement',
        'Type_personnel',
        'Grande_discipline',
        'Sexe',
        'Temps',
        'Effectif',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}