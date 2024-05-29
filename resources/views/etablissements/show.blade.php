@extends('layouts.app')

@section('styles')
    <style>
        html, body {
            height: 100%;
            overflow: visible;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h1>Détails de l'établissement :</h1><h1 class="titre_univ">{{ $etablissement->Etablissement }}</h1>

        <h2 class="text-center sousTitre">Informations Générales</h2>
        <div class="texteInfo">
            <p>
                <span class="NomInfo">Type d'établissement :</span>
                <span class="Info"> {{ $etablissement->Type }}</span>
            </p>
            <p>
                <span class="NomInfo">Secteur :</span>
                <span class="Info"> Secteur {{ $etablissement->Secteur }}</span>
            </p>
            <p>
                <span class="NomInfo">Commune :</span>
                <span class="Info"> {{ $etablissement->Commune }}</span>
            </p>
            <p>
                <span class="NomInfo">Département :</span>
                <span class="Info"> {{ $etablissement->Departement }}</span>
            </p>
            <p>
                <span class="NomInfo">Région :</span>
                <span class="Info"> {{ $etablissement->Region }}</span>
            </p>
            <p>
                <span class="NomInfo">Académie :</span>
                <span class="Info"> {{ $etablissement->Academie }}</span>
            </p>
            @if ($etablissement->Adresse)
                <p>
                    <span class="NomInfo">Adresse :</span>
                    <span class="Info"> {{ $etablissement->Adresse }}</span>
                </p>
            @endif
            @if ($etablissement->date_creation)
                <p>
                    <span class="NomInfo">Date de création :</span>
                    <span class="Info"> {{ $etablissement->date_creation }}</span>
                </p>
            @endif
            @if ($etablissement->contact)
                <p>
                    <span class="NomInfo">Numero de Téléphone :</span>
                    <span class="Info"> {{ $etablissement->contact }}</span>
                </p>
            @endif
        </div>
        
        @if ($etablissement->Etudiants_inscrits_2022)
            <h2 class="text-center sousTitre">Effectifs des Étudiants par Année</h2>
            <div class="row justify-content-center mt-5">
                <div class="col-md-4">
                    <table class="table text-center mx-auto">
                        <thead class="text-white">
                            <tr>
                                <th>Année</th>
                                <th>Nombre d'étudiants inscrits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2022</td>
                                <td>{{ $etablissement->Etudiants_inscrits_2022 }}</td>
                            </tr>
                            <tr>
                                <td>2021</td>
                                <td>{{ $etablissement->Etudiants_inscrits_2021 }}</td>
                            </tr>
                            <tr>
                                <td>2020</td>
                                <td>{{ $etablissement->Etudiants_inscrits_2020 }}</td>
                            </tr>
                            <tr>
                                <td>2019</td>
                                <td>{{ $etablissement->Etudiants_inscrits_2019 }}</td>
                            </tr>
                            <tr>
                                <td>2018</td>
                                <td>{{ $etablissement->Etudiants_inscrits_2018 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($etablissement->Personnels_non_enseignant || $etablissement->Enseignants)
            <h2 class="text-center sousTitre mb-5">Le Personnel</h2>
            @if ($etablissement->Personnels_non_enseignant)
                <p>
                    <span>Nombre de Personnels non enseignant : </span>
                    <span class="Info"> {{ $etablissement->Personnels_non_enseignant }}</span>
                </p>
            @endif
            @if ($etablissement->Enseignants)
                <p>
                    <span>Nombre d'Enseignants :</span>
                    <span class="Info"> {{ $etablissement->Enseignants }}</span>
                </p>
            @endif
        @endif

        @if ($etablissement->url || $etablissement->Wikipedia || $etablissement->facebook || $etablissement->twitter || $etablissement->instagram || $etablissement->linkedin)
            <h2 class="text-center sousTitre mb-5">Site Internet et Liens Sociaux</h2>
            @if ($etablissement->url)
                <p>
                    <span>Site Internet : </span>
                    <span><a href="{{ $etablissement->url }}">{{ $etablissement->url }}</a></span>
                </p>
            @endif
            @if ($etablissement->Wikipedia)
                <p>
                    <span>Wikipedia : </span>
                    <span><a href="{{ $etablissement->Wikipedia }}">{{ $etablissement->Wikipedia }}</a></span>
                </p>
            @endif
            @if ($etablissement->facebook)
                <p>
                    <span>Facebook : </span>
                    <span><a href="{{ $etablissement->facebook }}">{{ $etablissement->facebook }}</a></span>
            </p>
            @endif
            @if ($etablissement->twitter)
                <p>
                    <span>Twitter : </span>
                    <span><a href="{{ $etablissement->twitter }}">{{ $etablissement->twitter }}</a></span>
            </p>
            @endif
            @if ($etablissement->instagram)
                <p>
                    <span>Instagram : </span>
                    <span><a href="{{ $etablissement->instagram }}">{{ $etablissement->instagram }}</a></span>
                </p>
            @endif
            @if ($etablissement->linkedin)
                <p>
                    <span>Linkedin : </span> 
                    <span><a href="{{ $etablissement->linkedin }}">{{ $etablissement->linkedin }}</a></span>
                </p>
            @endif
        @endif

        <h2 class="text-center sousTitre mb-5">Autres Informations</h2>
        <p>
            <span>Donnée Géolocalisation :</span>
            <span> {{ $etablissement->Lon }},{{ $etablissement->Lat }}</span>
        </p>
        @if ($etablissement->siret)
            <p>
                <span>Numero de Siret :</span>
                <span> {{ $etablissement->siret }}</span>
            </p>
        @endif
    </div>
@endsection