<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnsNonPerm extends Model
{
    use HasFactory;

    protected $table = 'EnsNonPerm';

    protected $fillable = [
        'univ_id',
        'Effectif',
        'Effectif_H',
        'Effectif_F',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}