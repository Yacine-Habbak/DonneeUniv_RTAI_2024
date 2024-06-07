<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etablissement;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function telechargerPDF($id)
    {
        $etablissement = Etablissement::findOrFail($id);

        $pdf = PDF::loadView('etablissements.pdf', compact('etablissement'));

        return $pdf->download('fiche_etablissement.pdf');
    }
}