<?php

use App\Http\Controllers\RecupApiController;
use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\DisciplineController;


use Illuminate\Support\Facades\Route;


Route::get('/', [RecupApiController::class, 'RecupData']);

Route::get('/accueil', function () {
    return view('accueil');
})->name('accueil');

Route::get('/listeEtablissement', [EtablissementController::class, 'allEtablissement'])->name('etablissements.all');
Route::get('/listeDiscipline', [DisciplineController::class, 'allDiscipline'])->name('disciplines.all');





// Temporaire
Route::get('/statistiques', function () {
    return view('statistiques.index');
})->name('statistiques.index');