<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insertion extends Model
{
    use HasFactory;

    protected $table = 'insertions';

    protected $fillable = [
        'univ_id',
        'inser_Licence',
        'inser_Master_LMD',
        'inser_Master_MEEF',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'univ_id');
    }
}