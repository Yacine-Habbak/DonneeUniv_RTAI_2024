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
    
        $nomFichier = str_replace(' ', '_', 'fiche_' . $etablissement->Etablissement . '.pdf');
    
        return $pdf->download($nomFichier);
    }
}