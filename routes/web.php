<?php

use App\Http\Controllers\EtablissementController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\DiplomeController;


use Illuminate\Support\Facades\Route;


Route::get('/', [EtablissementController::class, 'RecupDataUnivFromApi']);
Route::get('/CalculTE', [EtablissementController::class, 'CalculTE'])->name('CalculTE');
Route::get('/DataDiscipline', [DisciplineController::class, 'RecupDataDisciplineFromApi'])->name('DataDiscipline');
Route::get('/DataEnseignant', [EnseignantController::class, 'RecupDataEnseignantFromApi'])->name('DataEnseignant');
Route::get('/DataPersonnel', [PersonnelController::class, 'RecupDataPersonnelFromApi'])->name('DataPersonnel');
Route::get('/DataStatistique', [StatistiqueController::class, 'RecupDataStatistiqueFromApi'])->name('DataStatistique');


Route::get('/accueil', function () {
    return view('accueil');
})->name('accueil');

Route::get('/carte', function () {
    return view('carte');
})->name('carte');

Route::get('/listeEtablissement', [EtablissementController::class, 'allEtablissement'])->name('etablissements.all');
Route::get('/etablissements', [EtablissementController::class, 'index'])->name('etablissements.index');

Route::get('/detailsEtablissement/{id}', [EtablissementController::class, 'showEtablissement'])->name('etablissements.show');

Route::get('/listeDiscipline', [DisciplineController::class, 'allDiscipline'])->name('disciplines.all');
Route::get('/statistiques', [StatistiqueController::class, 'allStatistique'])->name('statistiques.index');