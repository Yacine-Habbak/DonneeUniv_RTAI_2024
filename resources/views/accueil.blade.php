@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1>Portail des Données de l'Enseignement Supérieur</h1>
        <h3>Explorez les données des établissements,<br>les statistiques sur les étudiants,<br>et les taux d'insertion professionnelle<br>dans les académies françaises</h3>
        <img src="{{ asset('images/LeSaviezVous_1.png') }}" class="LeSaviezVous_1" alt="LeSaviezVous_1">
        <img src="{{ asset('images/LeSaviezVous_2.png') }}" class="LeSaviezVous_2" alt="LeSaviezVous_2">
        @include('include.carteAcad')

        <p class="texte_explication">Cliquez sur une académie pour accéder<br>aux informations détaillées sur les etablissements,<br>les étudiants, les ressources humaines<br>et les taux d'insertion professionnelle dans <br> l'académie séléctionnée.</p>
    

        <div class="d-flex justify-content-center position-bottom">
            <div class="me-3">
                <a href="{{ route('etablissements.all') }}" class="btn btn-success text-decoration-none bouton">Rechercher un Etablissement</a>
            </div>
            <div class="ms-3">
                <a href="{{ route('disciplines.all') }}" class="btn btn-primary text-decoration-none bouton">Consulter la liste des disciplines</a>
            </div>
        </div>
    
    </div>
@endsection