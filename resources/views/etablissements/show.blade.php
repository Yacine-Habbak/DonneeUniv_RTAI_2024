@extends('layouts.app')

@section('styles')
    <style>
        html, body {
            overflow: auto;
        }
        .footer {
            position: initial;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h1>Détails de l'établissement :</h1>
        <h1 class="titre_univ mb-5">{{ $etablissement->Etablissement }}</h1>


        <div class="row justify-content-around">
            
            <div class="col-md-{{ (($etablissement->url || $etablissement->Wikipedia || $etablissement->facebook || $etablissement->twitter || $etablissement->instagram || $etablissement->linkedin) ? '6' : '12') }}">
                <h2 class="text-center sousTitre mt-5 mb-5">Informations Générales</h2>
                <div class="texteInfo">
                    <p>
                        <span>Type d'établissement :</span>
                        <span class="Info"> {{ $etablissement->Type }}</span>
                    </p>
                    <p>
                        <span>Secteur :</span>
                        <span class="Info"> Secteur {{ $etablissement->Secteur }}</span>
                    </p>
                    <p>
                        <span>Commune :</span>
                        <span class="Info"> {{ $etablissement->Commune }}</span>
                    </p>
                    <p>
                        <span>Département :</span>
                        <span class="Info"> {{ $etablissement->Departement }}</span>
                    </p>
                    <p>
                        <span>Région :</span>
                        <span class="Info"> {{ $etablissement->Region }}</span>
                    </p>
                    <p>
                        <span>Académie :</span>
                        <span class="Info"> {{ $etablissement->Academie }}</span>
                    </p>
                    @if ($etablissement->Adresse)
                        <p>
                            <span>Adresse :</span>
                            <span class="Info"> {{ $etablissement->Adresse }}</span>
                        </p>
                    @endif
                    @if ($etablissement->date_creation)
                        <p>
                            <span>Date de création :</span>
                            <span class="Info"> {{ $etablissement->date_creation }}</span>
                        </p>
                    @endif
                    @if ($etablissement->contact)
                        <p>
                            <span>Numéro de Téléphone :</span>
                            <span class="Info"> {{ $etablissement->contact }}</span>
                        </p>
                    @endif
                </div>
            </div>

            @if ($etablissement->url || $etablissement->Wikipedia || $etablissement->facebook || $etablissement->twitter || $etablissement->instagram || $etablissement->linkedin)
                <div class="col-md-6">
                    <h2 class="text-center sousTitre mt-5 mb-5">Site Internet et Liens Sociaux</h2>
                    <div class="texteInfo">
                        @if ($etablissement->url)
                            <p>
                                <span class="NomInfo"><img src="{{ asset('images/sites/url.svg') }}" alt="Site internet" class="site-img"> Site Internet : </span>
                                <span><a href="{{ $etablissement->url }}" class="text-decoration-none">{{ $etablissement->Etablissement }}</a></span><br>
                            </p>
                        @endif
                        @if ($etablissement->Wikipedia)
                            <p>
                                <span class="NomInfo"><img src="{{ asset('images/sites/wikipedia.svg') }}" alt="Wikipedia" class="site-img"> Wikipedia : </span>
                                <span><a href="{{ $etablissement->Wikipedia }}" class="text-decoration-none">Page Wikipedia</a></span>
                            </p>
                        @endif
                        @if ($etablissement->facebook)
                            <p>
                                <span class="NomInfo"><img src="{{ asset('images/sites/facebook.png') }}" alt="Facebook" class="site-img"> Facebook : </span>
                                <span><a href="{{ $etablissement->facebook }}" class="text-decoration-none">Page Facebook</a></span>
                            </p>
                        @endif
                        @if ($etablissement->twitter)
                            <p>
                                <span class="NomInfo"><img src="{{ asset('images/sites/twitter.svg') }}" alt="Twitter" class="site-img"> Twitter : </span>
                                <span><a href="{{ $etablissement->twitter }}" class="text-decoration-none">Page Twitter</a></span>
                            </p>
                        @endif
                        @if ($etablissement->instagram)
                            <p>
                                <span class="NomInfo"><img src="{{ asset('images/sites/instagram.png') }}" alt="Instagram" class="site-img"> Instagram : </span>
                                <span><a href="{{ $etablissement->instagram }}" class="text-decoration-none">Page Instagram</a></span>
                            </p>
                        @endif
                        @if ($etablissement->linkedin)
                            <p>
                                <span class="NomInfo"><img src="{{ asset('images/sites/linkedin.png') }}" alt="Linkedin" class="site-img"> Linkedin : </span>
                                <span><a href="{{ $etablissement->linkedin }}" class="text-decoration-none">Page Linkedin</a></span>
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        
        @if ($etablissement->etudiants->Effectif_2022 && ($etablissement->Personnels_non_enseignant || $etablissement->Enseignants))
            <div class="row justify-content-around">
                <div class="col-md-4">
                    <h2 class="text-center sousTitre mt-5 mb-5">Effectifs des Étudiants par Année</h2>
                    <table class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Année</th>
                                <th>Nombre d'étudiants inscrits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($etablissement->etudiants->Effectif_2022) <tr><td>2022</td><td>{{ $etablissement->etudiants->Effectif_2022 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2021) <tr><td>2021</td><td>{{ $etablissement->etudiants->Effectif_2021 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2020) <tr><td>2020</td><td>{{ $etablissement->etudiants->Effectif_2020 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2019) <tr><td>2019</td><td>{{ $etablissement->etudiants->Effectif_2019 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2018) <tr><td>2018</td><td>{{ $etablissement->etudiants->Effectif_2018 }}</td></tr> @endif
                        </tbody>
                    </table>
                </div>

                <div class="col-md-3">
                    <h2 class="text-center sousTitre mt-5 mb-5">Le Personnel</h2>
                    <table class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Nombre de Personnel</th>
                                <th>Nombre d'enseignants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $etablissement->Personnels_non_enseignant }}</td>
                                <td>{{ $etablissement->Enseignants }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <h2 class="text-center sousTitre mt-5 mb-5">Autres Informations</h2>
                    <div class="texteInfo">
                        <p>
                            <span>Donnée de Géolocalisation :</span>
                            <span class="Info"> {{ $etablissement->lon }},{{ $etablissement->lat }}</span>
                        </p>
                        @if ($etablissement->siret)
                            <p>
                                <span>Numéro de Siret :</span>
                                <span class="Info"> {{ $etablissement->siret }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

        @elseif ($etablissement->etudiants->Effectif_2022 && !($etablissement->Personnels_non_enseignant || $etablissement->Enseignants))
            <div class="row justify-content-around decalage">
                <div class="col-md-4">
                    <h2 class="text-center sousTitre mt-5 mb-5">Effectifs des Étudiants par Année</h2>
                    <table class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Année</th>
                                <th>Nombre d'étudiants inscrits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($etablissement->etudiants->Effectif_2022) <tr><td>2022</td><td>{{ $etablissement->etudiants->Effectif_2022 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2021) <tr><td>2021</td><td>{{ $etablissement->etudiants->Effectif_2021 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2020) <tr><td>2020</td><td>{{ $etablissement->etudiants->Effectif_2020 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2019) <tr><td>2019</td><td>{{ $etablissement->etudiants->Effectif_2019 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2018) <tr><td>2018</td><td>{{ $etablissement->etudiants->Effectif_2018 }}</td></tr> @endif
                        </tbody>
                    </table>
                </div>

                <div class="col-md-8">
                    <h2 class="text-center sousTitre mt-5 mb-5">Autres Informations</h2>
                    <div class="texteInfo">
                        <p>
                            <span>Donnée de Géolocalisation :</span>
                            <span class="Info"> {{ $etablissement->lon }},{{ $etablissement->lat }}</span>
                        </p>
                        @if ($etablissement->siret)
                            <p>
                                <span>Numéro de Siret :</span>
                                <span class="Info"> {{ $etablissement->siret }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @elseif (!$etablissement->etudiants->Effectif_2022 && ($etablissement->Personnels_non_enseignant || $etablissement->Enseignants))
            <div class="row justify-content-around decalage">
                <div class="col-md-3">
                    <h2 class="text-center sousTitre mt-5 mb-5">Le Personnel</h2>
                    <table class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Nombre de Personnel</th>
                                <th>Nombre d'enseignants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $etablissement->Personnels_non_enseignant }}</td>
                                <td>{{ $etablissement->Enseignants }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-9">
                    <h2 class="text-center sousTitre mt-5 mb-5">Autres Informations</h2>
                    <div class="texteInfo">
                        <p>
                            <span>Donnée de Géolocalisation :</span>
                            <span class="Info"> {{ $etablissement->lon }},{{ $etablissement->lat }}</span>
                        </p>
                        @if ($etablissement->siret)
                            <p>
                                <span>Numéro de Siret :</span>
                                <span class="Info"> {{ $etablissement->siret }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <h2 class="text-center sousTitre mt-5 mb-5">Autres Informations</h2>
                    <div class="texteInfo">
                        <p>
                            <span>Donnée de Géolocalisation :</span>
                            <span class="Info"> {{ $etablissement->lon }},{{ $etablissement->lat }}</span>
                        </p>
                        @if ($etablissement->siret)
                            <p>
                                <span>Numéro de Siret :</span>
                                <span class="Info"> {{ $etablissement->siret }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="row justify-content-center mt-5 mb-5">
        <a href="#" class="text-decoration-none justify-content-end btn_telecharger">Télécharger la fiche</a>
        <a href="#" id="btn_retour" class="text-decoration-none justify-content-end">Retour</a>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btnRetour = document.getElementById('btn_retour');

            btnRetour.addEventListener('click', function(event) {
                event.preventDefault();
                window.history.back();
            });
        });
    </script>
@endsection