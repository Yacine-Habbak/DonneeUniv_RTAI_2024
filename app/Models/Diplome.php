<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    use HasFactory;

    protected $table = 'diplomes';

    protected $fillable = [
        'univ_id',
        'Type',
        'Diplome',
        'nbr_Pour',
        'nbr_Sort',
        'TI',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}