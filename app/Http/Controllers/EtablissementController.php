<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    public function allEtablissement()
    {
        $etablissement = Etablissement::all();
        return view('etablissements.all', compact('etablissement'));
    }
}