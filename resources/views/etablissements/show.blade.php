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
            <!-- SECTION informations generales -->
            <div class="col-md-6">
                <h2 class="text-center sousTitre mt-5 mb-4">Informations Générales</h2>
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

            <!-- SECTION sites internet -->
            <div class="col-md-6">
                @if ($etablissement->url || $etablissement->Wikipedia || $etablissement->facebook || $etablissement->twitter || $etablissement->instagram || $etablissement->linkedin)
                    <h2 class="text-center sousTitre mt-5 mb-4">Site Internet et Liens Sociaux</h2>
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
                @endif

                <!-- SECTION autres informations -->
                <div class="col-md-12">
                    <h2 class="text-center sousTitre mt-5 mb-4">Autres Informations</h2>
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
        </div>

        <div class="row d-flex justify-content-center flex-wrap">
            <!--Tableau des Effectifs des Étudiants par Année-->
            @if (($etablissement->etudiants->Effectif_2022) || ($etablissement->etudiants->Effectif_2021) || ($etablissement->etudiants->Effectif_2020) || ($etablissement->etudiants->Effectif_2019) || ($etablissement->etudiants->Effectif_2018) || ($etablissement->etudiants->Effectif_2017) || ($etablissement->etudiants->Effectif_2016) || ($etablissement->etudiants->Effectif_2015) || ($etablissement->etudiants->Effectif_2014) || ($etablissement->etudiants->Effectif_2013))
                <div class="col-md-4 p-3">
                    <h2 class="text-center sousTitre mt-5 mb-4">Effectifs des Étudiants par Année</h2>
                    <div class="btn-group btn_eff_etu" role="group">
                        @if (($etablissement->etudiants->Effectif_2021) && ($etablissement->etudiants->Effectif_2022))
                            <button type="button" class="btn btn-outline-primary active" data-vue="tab_eff_etu">Vue Tableau</button>
                            <button type="button" class="btn btn-outline-primary" data-vue="graph_eff_etu">Vue Graphique</button>
                        @endif
                    </div>
                    <table id="table_eff_etu" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th style="cursor: pointer;">Année</th>
                                <th style="cursor: pointer;">Nombre d'étudiants inscrits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($etablissement->etudiants->Effectif_2022) <tr><td>2022</td><td>{{ $etablissement->etudiants->Effectif_2022 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2021) <tr><td>2021</td><td>{{ $etablissement->etudiants->Effectif_2021 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2020) <tr><td>2020</td><td>{{ $etablissement->etudiants->Effectif_2020 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2019) <tr><td>2019</td><td>{{ $etablissement->etudiants->Effectif_2019 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2018) <tr><td>2018</td><td>{{ $etablissement->etudiants->Effectif_2018 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2017) <tr><td>2017</td><td>{{ $etablissement->etudiants->Effectif_2017 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2016) <tr><td>2016</td><td>{{ $etablissement->etudiants->Effectif_2016 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2015) <tr><td>2015</td><td>{{ $etablissement->etudiants->Effectif_2015 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2014) <tr><td>2014</td><td>{{ $etablissement->etudiants->Effectif_2014 }}</td></tr> @endif
                            @if ($etablissement->etudiants->Effectif_2013) <tr><td>2013</td><td>{{ $etablissement->etudiants->Effectif_2013 }}</td></tr> @endif
                        </tbody>
                    </table>
                    <canvas id="graph_eff_etu" width="100" height="100"></canvas>
                </div>
            @endif

            <!--Tableau du nombre de enseignants-->
            @if ($etablissement->enseignants->isNotEmpty())
                <div class="col-md-4 p-3">
                    <h2 class="text-center sousTitre mt-5 mb-4">Les Enseignants<sup>*</sup></h2>
                    <div class="btn-group btn_ens" role="group">
                        <button type="button" class="btn btn-outline-primary active" data-vue="tab_ens_Titu">Titulaires</button>
                        <button type="button" class="btn btn-outline-primary" data-vue="tab_ens_NP">Non Permanents</button>
                    </div>
                    <div class="btn-group btn_ens_vue" role="group" id="vue-options">
                        <button type="button" class="btn btn-outline-primary active" data-vue="tab_ens">Vue Tableau</button>
                        <button type="button" class="btn btn-outline-primary" data-vue="graph_ens">Vue Graphique</button>
                    </div>
                    <div class="btn-group btn_graph_ens" role="group" id="graphique-options" style="display: none;">
                        <button type="button" class="btn btn-outline-primary active" data-vue="graph_type_ens">Type d'enseignant</button>
                        <button type="button" class="btn btn-outline-primary" data-vue="graph_genre_ens">Genre</button>
                    </div>
                    <table id="table_ens_Titu" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th></th>
                                <th style="cursor: pointer;">Effectif Total</th>
                                <th style="cursor: pointer;">Effectif Homme</th>
                                <th style="cursor: pointer;">Effectif Femme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Enseignants du 2nd degré et Arts et métiers</th>
                                @php
                                    $arts = $etablissement->enseignants->where('Type', 'Enseignants du 2nd degré et Arts et métiers')->first();
                                @endphp
                                <td>{{ $arts->Effectif ?? 'nd' }}</td>
                                <td>{{ $arts->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $arts->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Maître de conférences et assimilés</th>
                                @php
                                    $conference = $etablissement->enseignants->where('Type', 'Maître de conférences et assimilés')->first();
                                @endphp
                                <td>{{ $conference->Effectif ?? 'nd' }}</td>
                                <td>{{ $conference->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $conference->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Professeur et assimilés</th>
                                @php
                                    $prof = $etablissement->enseignants->where('Type', 'Professeur et assimilés')->first();
                                @endphp
                                <td>{{ $prof->Effectif ?? 'nd' }}</td>
                                <td>{{ $prof->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $prof->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th class="text-white" style="background-color: #274CFF;font-size: 1vw;">Total</th>
                                    <td>{{ ($arts->Effectif ?? 0) + ($conference->Effectif ?? 0) + ($prof->Effectif ?? 0) }}</td>
                                    <td>{{ ($arts->Effectif_H ?? 0) + ($conference->Effectif_H ?? 0) + ($prof->Effectif_H ?? 0) }}</td>
                                    <td>{{ ($arts->Effectif_F ?? 0) + ($conference->Effectif_F ?? 0) + ($prof->Effectif_F ?? 0) }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>

                    <table id="table_ens_NP" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th></th>
                                <th style="cursor: pointer;">Effectif Total</th>
                                <th style="cursor: pointer;">Effectif Homme</th>
                                <th style="cursor: pointer;">Effectif Femme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Attaché temporaire d'enseignement et de recherche</th>
                                @php
                                    $attacheTemporaire = $etablissement->ensnonperm->where('Type', 'Attaché temporaire d\'enseignement et de recherche')->first();
                                @endphp
                                <td>{{ $attacheTemporaire->Effectif ?? 'nd' }}</td>
                                <td>{{ $attacheTemporaire->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $attacheTemporaire->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Doctorant contractuel sans service d'enseignement</th>
                                @php
                                    $doctorantSansService = $etablissement->ensnonperm->where('Type', 'Doctorant contractuel sans service d\'enseignement')->first();
                                @endphp
                                <td>{{ $doctorantSansService->Effectif ?? 'nd' }}</td>
                                <td>{{ $doctorantSansService->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $doctorantSansService->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Doctorant contractuel avec service d'enseignement</th>
                                @php
                                    $doctorantAvecService = $etablissement->ensnonperm->where('Type', 'Doctorant contractuel avec service d\'enseignement')->first();
                                @endphp
                                <td>{{ $doctorantAvecService->Effectif ?? 'nd' }}</td>
                                <td>{{ $doctorantAvecService->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $doctorantAvecService->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Contractuel LRU</th>
                                @php
                                    $contractuelLRU = $etablissement->ensnonperm->where('Type', 'Contractuel LRU')->first();
                                @endphp
                                <td>{{ $contractuelLRU->Effectif ?? 'nd' }}</td>
                                <td>{{ $contractuelLRU->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $contractuelLRU->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Maître de conférences associé</th>
                                @php
                                    $maitreConferencesAssocie = $etablissement->ensnonperm->where('Type', 'Maître de conférences associé')->first();
                                @endphp
                                <td>{{ $maitreConferencesAssocie->Effectif ?? 'nd' }}</td>
                                <td>{{ $maitreConferencesAssocie->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $maitreConferencesAssocie->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Contractuel 2nd degré</th>
                                @php
                                    $contractuel2ndDegre = $etablissement->ensnonperm->where('Type', 'Contractuel 2nd degré')->first();
                                @endphp
                                <td>{{ $contractuel2ndDegre->Effectif ?? 'nd' }}</td>
                                <td>{{ $contractuel2ndDegre->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $contractuel2ndDegre->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Professeur des universités associé</th>
                                @php
                                    $professeurAssocie = $etablissement->ensnonperm->where('Type', 'Professeur des universités associé')->first();
                                @endphp
                                <td>{{ $professeurAssocie->Effectif ?? 'nd' }}</td>
                                <td>{{ $professeurAssocie->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $professeurAssocie->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Professeur des universités invité</th>
                                @php
                                    $professeurInvite = $etablissement->ensnonperm->where('Type', 'Professeur des universités invité')->first();
                                @endphp
                                <td>{{ $professeurInvite->Effectif ?? 'nd' }}</td>
                                <td>{{ $professeurInvite->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $professeurInvite->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Lecteur et répétiteur de langues étrangères</th>
                                @php
                                    $lecteurRepetiteur = $etablissement->ensnonperm->where('Type', 'Lecteur et répétiteur de langues étrangères')->first();
                                @endphp
                                <td>{{ $lecteurRepetiteur->Effectif ?? 'nd' }}</td>
                                <td>{{ $lecteurRepetiteur->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $lecteurRepetiteur->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Maître de conférences invité</th>
                                @php
                                    $maitreConferencesInvite = $etablissement->ensnonperm->where('Type', 'Maître de conférences invité')->first();
                                @endphp
                                <td>{{ $maitreConferencesInvite->Effectif ?? 'nd' }}</td>
                                <td>{{ $maitreConferencesInvite->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $maitreConferencesInvite->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Maître de langues étrangères</th>
                                @php
                                    $maitreLanguesEtrangeres = $etablissement->ensnonperm->where('Type', 'Maître de langues étrangères')->first();
                                @endphp
                                <td>{{ $maitreLanguesEtrangeres->Effectif ?? 'nd' }}</td>
                                <td>{{ $maitreLanguesEtrangeres->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $maitreLanguesEtrangeres->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Invité (corps non renseigné)</th>
                                @php
                                    $inviteNonRenseigne = $etablissement->ensnonperm->where('Type', 'Invité (corps non renseigné)')->first();
                                @endphp
                                <td>{{ $inviteNonRenseigne->Effectif ?? 'nd' }}</td>
                                <td>{{ $inviteNonRenseigne->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $inviteNonRenseigne->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th class="text-white" style="background-color: #274CFF;font-size: 1vw;">Total</th>
                                    <td>{{ ($attacheTemporaire->Effectif ?? 0) + ($doctorantSansService->Effectif ?? 0) + ($doctorantAvecService->Effectif ?? 0) + ($contractuelLRU->Effectif ?? 0) + ($maitreConferencesAssocie->Effectif ?? 0) + ($contractuel2ndDegre->Effectif ?? 0) + ($professeurAssocie->Effectif ?? 0) + ($professeurInvite->Effectif ?? 0) + ($lecteurRepetiteur->Effectif ?? 0) + ($maitreConferencesInvite->Effectif ?? 0) + ($maitreLanguesEtrangeres->Effectif ?? 0) + ($inviteNonRenseigne->Effectif ?? 0) }}</td>
                                    <td>{{ ($attacheTemporaire->Effectif_H ?? 0) + ($doctorantSansService->Effectif_H ?? 0) + ($doctorantAvecService->Effectif_H ?? 0) + ($contractuelLRU->Effectif_H ?? 0) + ($maitreConferencesAssocie->Effectif_H ?? 0) + ($contractuel2ndDegre->Effectif_H ?? 0) + ($professeurAssocie->Effectif_H ?? 0) + ($professeurInvite->Effectif_H ?? 0) + ($lecteurRepetiteur->Effectif_H ?? 0) + ($maitreConferencesInvite->Effectif_H ?? 0) + ($maitreLanguesEtrangeres->Effectif_H ?? 0) + ($inviteNonRenseigne->Effectif_H ?? 0) }}</td>
                                    <td>{{ ($attacheTemporaire->Effectif_F ?? 0) + ($doctorantSansService->Effectif_F ?? 0) + ($doctorantAvecService->Effectif_F ?? 0) + ($contractuelLRU->Effectif_F ?? 0) + ($maitreConferencesAssocie->Effectif_F ?? 0) + ($contractuel2ndDegre->Effectif_F ?? 0) + ($professeurAssocie->Effectif_F ?? 0) + ($professeurInvite->Effectif_F ?? 0) + ($lecteurRepetiteur->Effectif_F ?? 0) + ($maitreConferencesInvite->Effectif_F ?? 0) + ($maitreLanguesEtrangeres->Effectif_F ?? 0) + ($inviteNonRenseigne->Effectif_F ?? 0) }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>

                    <canvas id="graph_genre_ens" class="mt-5" width="100" height="100"></canvas>
                    <canvas id="graph_type_ens" class="mt-5" width="100" height="100"></canvas>
                </div>
            @endif

            <!--Tableau du nombre de personnels-->
            @if ($etablissement->personnels->isNotEmpty())
                <div class="col-md-4 p-3">
                    <h2 class="text-center sousTitre mt-5 mb-4">Le Personnel<sup>*</sup></h2>
                    <div class="btn-group btn_pers" role="group">
                        <button type="button" class="btn btn-outline-primary active" data-vue="tab_pers">Vue Tableau</button>
                        <button type="button" class="btn btn-outline-primary" data-vue="graph_pers">Vue Graphique</button>
                    </div>
                    <div class="btn-group btn_graph_pers" role="group" id="graphique-options" style="display: none;">
                        <button type="button" class="btn btn-outline-primary active" data-vue="graph_type_pers">Type de personnel</button>
                        <button type="button" class="btn btn-outline-primary" data-vue="graph_genre_pers">Genre</button>
                    </div>
                    <table id="table_personnels" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th></th>
                                <th style="cursor: pointer;">Effectif Total</th>
                                <th style="cursor: pointer;">Effectif Homme</th>
                                <th style="cursor: pointer;">Effectif Femme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Titulaires</th>
                                @php
                                    $titulaires = $etablissement->personnels->where('Type', 'titulaires')->first();
                                @endphp
                                <td>{{ $titulaires->Effectif ?? 'nd' }}</td>
                                <td>{{ $titulaires->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $titulaires->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="text-white" style="background-color: #274CFF;">Contractuels</th>
                                @php
                                    $contractuels = $etablissement->personnels->where('Type', 'contractuels')->first();
                                @endphp
                                <td>{{ $contractuels->Effectif ?? 'nd' }}</td>
                                <td>{{ $contractuels->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $contractuels->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th class="text-white" style="background-color: #274CFF;font-size: 1vw;">Total</th>
                                    <td>{{ $etablissement->Personnels_non_enseignant ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Personnels_non_enseignant_H ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Personnels_non_enseignant_F ?? 'nd' }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                    <canvas id="graph_genre_pers" class="mt-5" width="100" height="100"></canvas>
                    <canvas id="graph_type_pers" class="mt-5" width="100" height="100"></canvas>
                </div>
                <span>* : Donnée 2021</span>
            @endif
        </div>

        <!-- Liste des disciplines -->
        @if ($etablissement->disciplines->isNotEmpty())
                <h2 class="text-center sousTitre mt-5 mb-4">Les Disciplines enseignées</h2>
                <div class="row justify-content-center">
                    <div class="col-md-4 offset-md-2">
                        <ul>
                            @foreach ($etablissement->disciplines as $discipline)
                                @php
                                    $disciplineList = explode('//', $discipline->Discipline);
                                    $middleIndex = floor(count($disciplineList) / 2);
                                    $firstHalf = array_slice($disciplineList, 0, $middleIndex);
                                @endphp
                                @foreach ($firstHalf as $item)
                                    <li class="discipline_champs">{{ $item }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul>
                            @foreach ($etablissement->disciplines as $discipline)
                                @php
                                    $disciplineList = explode('//', $discipline->Discipline);
                                    $middleIndex = floor(count($disciplineList) / 2);
                                    $secondHalf = array_slice($disciplineList, $middleIndex);
                                @endphp
                                @foreach ($secondHalf as $item)
                                    <li class="discipline_champs">{{ $item }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
        @endif


        <div class="row d-flex justify-content-center flex-wrap">
            <!--Tableau des diplomes -->
            @if ($etablissement->diplomes->isNotEmpty())
                <h2 class="text-center sousTitre mt-5 mb-4">Les Diplômes</h2>

                @php
                    $LicencePro_Dispo = false;
                    $MasterLMD_Dispo = false;
                    $MasterMEEF_Dispo = false;
                    $NbrPour = $etablissement->diplomes->pluck('nbr_Pour')->filter()->isNotEmpty();
                    $NbrSort = $etablissement->diplomes->pluck('nbr_Sort')->filter()->isNotEmpty();
                @endphp

                @foreach($etablissement->diplomes as $diplome)
                    @if ($diplome->Type === "Licence professionnelle")
                        @php $LicencePro_Dispo = true; @endphp
                    @elseif ($diplome->Type === "Master LMD")
                        @php $MasterLMD_Dispo = true; @endphp
                    @elseif ($diplome->Type === "Master MEEF")
                        @php $MasterMEEF_Dispo = true; @endphp
                    @endif
                @endforeach

                @if ($LicencePro_Dispo)
                    <div class="col-md-4">
                        <h3 class="text-center">Licence Professionnelle</h3>
                        <div class="defiler_Table">
                            <table id="table-licence" class="table text-center">
                                <thead class="text-white diplome_titre">
                                <tr>
                                    <th style="cursor: pointer;">Nom du Diplôme</th>
                                    @if ($NbrPour || $NbrSort)
                                        <th style="cursor: pointer;">Nombre de poursuivants</th>
                                        <th style="cursor: pointer;">Nombre de sortants</th>
                                    @endif
                                    <th style="cursor: pointer;">TI<sup>**</sup></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($etablissement->diplomes as $diplome)
                                        @if ($diplome->Type === "Licence professionnelle")
                                            <tr>
                                                <td class="diplome_champs">{{ $diplome->Diplome }}</td>
                                                @if ($NbrPour || $NbrSort)
                                                    <td class="diplome_champs">{{ $diplome->nbr_Pour ?? 'nd'}}</td>
                                                    <td class="diplome_champs">{{ $diplome->nbr_Sort ?? 'nd'}}</td>
                                                @endif
                                                <td class="diplome_champs">{{ $diplome->TI ?? 'nd'}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if ($MasterLMD_Dispo)
                    <div class="col-md-4">
                        <h3 class="text-center">Master LMD</h3>
                        <div class="defiler_Table">
                            <table id="table-masterLMD" class="table text-center">
                                <thead class="text-white diplome_titre">
                                    <tr>
                                        <th style="cursor: pointer;">Nom du Diplôme</th>
                                        @if ($NbrPour || $NbrSort)
                                            <th style="cursor: pointer;">Nombre de poursuivants</th>
                                            <th style="cursor: pointer;">Nombre de sortants</th>
                                        @endif
                                        <th style="cursor: pointer;">TI<sup>**</sup></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etablissement->diplomes as $diplome)
                                        @if ($diplome->Type === "Master LMD")
                                            <tr>
                                                <td class="diplome_champs">{{ $diplome->Diplome }}</td>
                                                @if ($NbrPour || $NbrSort)
                                                    <td class="diplome_champs">{{ $diplome->nbr_Pour ?? 'nd'}}</td>
                                                    <td class="diplome_champs">{{ $diplome->nbr_Sort ?? 'nd'}}</td>
                                                @endif
                                                <td class="diplome_champs">{{ $diplome->TI ?? 'nd'}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if ($MasterMEEF_Dispo)
                    <div class="col-md-4">
                        <h3 class="text-center">Master MEEF</h3>
                        <div class="defiler_Table">
                            <table id="table-masterMEEF" class="table text-center">
                                <thead class="text-white diplome_titre">
                                    <tr>
                                        <th style="cursor: pointer;">Nom du Diplôme</th>
                                        @if ($NbrPour || $NbrSort)
                                            <th style="cursor: pointer;">Nombre de poursuivants</th>
                                            <th style="cursor: pointer;">Nombre de sortants</th>
                                        @endif
                                        <th style="cursor: pointer;">TI<sup>**</sup></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etablissement->diplomes as $diplome)
                                        @if ($diplome->Type === "Master MEEF")
                                            <tr>
                                                <td class="diplome_champs">{{ $diplome->Diplome }}</td>
                                                @if ($NbrPour || $NbrSort)
                                                    <td class="diplome_champs">{{ $diplome->nbr_Pour ?? 'nd'}}</td>
                                                    <td class="diplome_champs">{{ $diplome->nbr_Sort ?? 'nd'}}</td>
                                                @endif
                                                <td class="diplome_champs">{{ $diplome->TI ?? 'nd'}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <span>** : Taux d'insertion 18 mois apres le diplome obtenu en 2019/2020</span>
            @endif
        </div>
            

        <!-- Bouton Telecharger et Retour -->
        <div class="row justify-content-center mt-5">
            <a href="{{ route('telecharger.pdf', $etablissement->id) }}" class="text-decoration-none justify-content-end btn_telecharger">Télécharger la fiche</a>
            <a href="#" id="btn_retour" class="text-decoration-none justify-content-end">Retour</a>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btnRetour = document.getElementById('btn_retour');
            btnRetour.addEventListener('click', function(event) {
                event.preventDefault();
                window.history.back();
            });
        });

        $(document).ready(function() {
            // Initialisation DataTable
            function initialiserDataTable(tableId, options = {}) {
                const optionsDataTable = {
                    paging: false,
                    info: false,
                    searching: false,
                    rowCallback: function(row, data, index) {
                        if ($(row).hasClass('total')) {
                            $(row).appendTo($(row).closest('table').find('tbody'));
                        }
                    }
                };
                
                const finalOptions = $.extend(true, {}, optionsDataTable, options);
                
                return $(tableId).DataTable(finalOptions);
            }

            var tableEtudiants = initialiserDataTable('#table_eff_etu');
            var tablePersonnels = initialiserDataTable('#table_personnels');
            var tableEnseignantsTitu = initialiserDataTable('#table_ens_Titu');
            var tableEnseignantsNP = initialiserDataTable('#table_ens_NP');
            var tableLicence = initialiserDataTable('#table-licence');
            var tableMasterLMD = initialiserDataTable('#table-masterLMD');
            var tableMasterMEEF = initialiserDataTable('#table-masterMEEF');

            // Fonction pour créer un graphique linéaire
            function dessinerGraphique(data, canvasId) {
                var ctx = document.getElementById(canvasId);
                
                if (Chart.getChart(ctx)) {
                    Chart.getChart(ctx).destroy();
                }
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.annee),
                        datasets: [{
                            label: 'Evolution des effectifs étudiant',
                            data: data.map(item => item.nombre),
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Fonction pour créer un graphique camembert
            function Camembert_genre(data, containerId) {
                var ctx = document.getElementById(containerId).getContext('2d');

                if (Chart.getChart(ctx)) {
                    Chart.getChart(ctx).destroy();
                }

                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Hommes', 'Femmes'],
                        datasets: [{
                            data: [data.hommes, data.femmes],
                            backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Répartition par genre - Donnée 2021'
                            }
                        }
                    }
                });
            }

            // Boutons pour les effectifs des étudiants
            var graphEtudiants;
            $('.btn_eff_etu button').on('click', function() {
                var vue = $(this).data('vue');
                if (vue === 'tab_eff_etu') {
                    $('#table_eff_etu').show();
                    $('#graph_eff_etu').hide();
                    if (graphEtudiants) {
                        graphEtudiants.destroy();
                    }
                } else {
                    $('#table_eff_etu').hide();

                    var data = [];
                    $('#table_eff_etu tbody tr').each(function() {
                        var annee = $(this).find('td:first-child').text();
                        var nombre = $(this).find('td:last-child').text();
                        data.push({ annee: annee, nombre: parseInt(nombre) });
                    });

                    if (graphEtudiants) {
                        graphEtudiants.destroy();
                    }
                    graphEtudiants = dessinerGraphique(data, 'graph_eff_etu');
                }
                $(this).addClass('active').siblings().removeClass('active');
            });

            // Boutons pour les personnels
            var graphGenrePersonnels;
            var graphTypePersonnels;
            $('.btn_pers button').on('click', function() {
                var vue = $(this).data('vue');
                if (vue === 'tab_pers') {
                    $('#table_personnels').show();
                    $('#graph_genre_pers').hide();
                    $('#graph_type_pers').hide();
                    if (graphGenrePersonnels) {
                        graphGenrePersonnels.destroy();
                    }
                    if (graphTypePersonnels) {
                        graphTypePersonnels.destroy();
                    }
                    $('.btn_graph_pers').hide();
                } else {
                    $('#table_personnels').hide();
                    $('.btn_graph_pers').show();
                    $('.btn_graph_pers button').first().trigger('click');
                }
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.btn_graph_pers button').on('click', function() {
                var vue = $(this).data('vue');
                if (vue === 'graph_genre_pers') {
                    $('#graph_genre_pers').show();
                    $('#graph_type_pers').hide();

                    var hommes = parseInt($('#table_personnels tfoot tr td:nth-child(3)').text());
                    var femmes = parseInt($('#table_personnels tfoot tr td:nth-child(4)').text());

                    if (graphGenrePersonnels) {
                        graphGenrePersonnels.destroy();
                    }
                    graphGenrePersonnels = Camembert_genre({ hommes: hommes, femmes: femmes }, 'graph_genre_pers');
                } else if (vue === 'graph_type_pers') {
                    $('#graph_genre_pers').hide();
                    $('#graph_type_pers').show();

                    var typeData = [
                        {
                            label: "Contractuels",
                            value: parseInt($('#table_personnels tbody tr:nth-child(1) td:nth-child(2)').text()) || 0
                        },
                        {
                            label: "Titulaires",
                            value: parseInt($('#table_personnels tbody tr:nth-child(2) td:nth-child(2)').text()) || 0
                        },
                    ];

                    if (graphTypePersonnels) {
                        graphTypePersonnels.destroy();
                    }
                    graphTypePersonnels = Camembert_type_pers(typeData, 'graph_type_pers');
                }
                $(this).addClass('active').siblings().removeClass('active');
            });

            // gérer les enseignants (titulaires et non permanents)
            var graphGenreEnsTitu, graphTypeEnsTitu, graphGenreEnsNP, graphTypeEnsNP;

            function gererAffichageEns(typeDonnees, typeVue) {
                $('#table_ens_Titu, #table_ens_NP, #graph_genre_ens, #graph_type_ens').hide();
                $('.btn_graph_ens').hide();

                if (typeVue === 'tab_ens') {
                    $(`#table_ens_${typeDonnees}`).show();
                } else {
                    $('.btn_graph_ens').show();
                    let activeGraphType = $('.btn_graph_ens .active').data('vue');
                    $(`#${activeGraphType}`).show();

                    let ctx = document.getElementById(activeGraphType).getContext('2d');
                    let data, labels, title;

                    if (activeGraphType === 'graph_genre_ens') {
                        if (typeDonnees === 'Titu') {
                            let hommes = parseInt($('#table_ens_Titu tfoot tr td:nth-child(3)').text());
                            let femmes = parseInt($('#table_ens_Titu tfoot tr td:nth-child(4)').text());
                            data = [hommes, femmes];
                            labels = ['Hommes', 'Femmes'];
                            title = 'Répartition par genre - Enseignants Titulaires';
                            graphGenreEnsTitu = Camembert_genre({ hommes: hommes, femmes: femmes }, 'graph_genre_ens');
                        } else {
                            let hommes = parseInt($('#table_ens_NP tfoot tr td:nth-child(3)').text());
                            let femmes = parseInt($('#table_ens_NP tfoot tr td:nth-child(4)').text());
                            data = [hommes, femmes];
                            labels = ['Hommes', 'Femmes'];
                            title = 'Répartition par genre - Enseignants Non Permanents';
                            graphGenreEnsNP = Camembert_genre({ hommes: hommes, femmes: femmes }, 'graph_genre_ens');
                        }
                    } else {
                        if (typeDonnees === 'Titu') {
                            let rawData = $('#table_ens_Titu tbody tr').map(function() {
                                return {
                                    label: $(this).find('th').text(),
                                    value: parseInt($(this).find('td:nth-child(2)').text()) || 0
                                };
                            }).get();

                            let filteredData = rawData.filter(item => item.value > 0);
                            data = filteredData.map(item => item.value);
                            labels = filteredData.map(item => item.label);
                            title = 'Répartition par type - Enseignants Titulaires';
                            graphTypeEnsTitu = Camembert_type_ens(filteredData, 'graph_type_ens');
                        } else {
                            let rawData = $('#table_ens_NP tbody tr').map(function() {
                                return {
                                    label: $(this).find('th').text(),
                                    value: parseInt($(this).find('td:nth-child(2)').text()) || 0
                                };
                            }).get();

                            let filteredData = rawData.filter(item => item.value > 0);
                            data = filteredData.map(item => item.value);
                            labels = filteredData.map(item => item.label);
                            title = 'Répartition par type - Enseignants Non Permanents';
                            graphTypeEnsNP = Camembert_type_ens(filteredData, 'graph_type_ens');
                        }
                    }
                }
            }

            $('.btn_ens button').on('click', function() {
                $(this).addClass('active').siblings().removeClass('active');
                let typeDonnees = $(this).data('vue').split('_')[2];
                let typeVue = $('.btn_ens_vue .active').data('vue');
                gererAffichageEns(typeDonnees, typeVue);
            });

            $('.btn_ens_vue button').on('click', function() {
                $(this).addClass('active').siblings().removeClass('active');
                let typeDonnees = $('.btn_ens .active').data('vue').split('_')[2];
                let typeVue = $(this).data('vue');
                gererAffichageEns(typeDonnees, typeVue);
            });

            $('.btn_graph_ens button').on('click', function() {
                $(this).addClass('active').siblings().removeClass('active');
                let typeDonnees = $('.btn_ens .active').data('vue').split('_')[2];
                let typeVue = 'graph_ens';
                gererAffichageEns(typeDonnees, typeVue);
            });

            gererAffichageEns('Titu', 'tab_ens');

            // Fonction pour créer un graphique camembert des types d'enseignants
            function Camembert_type_ens(data, containerId) {
                var ctx = document.getElementById(containerId).getContext('2d');

                if (Chart.getChart(ctx)) {
                    Chart.getChart(ctx).destroy();
                }

                var colors = [
                    'rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)',
                    'rgba(199, 199, 199, 0.5)', 'rgba(83, 102, 255, 0.5)', 'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'
                ];
                var borderColors = colors.map(color => color.replace('0.5', '1'));

                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.map(item => item.label),
                        datasets: [{
                            data: data.map(item => item.value),
                            backgroundColor: colors.slice(0, data.length),
                            borderColor: borderColors.slice(0, data.length),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Répartition par type d\'enseignant - Donnée 2021'
                            }
                        }
                    }
                });
            }


            // Fonction pour créer un graphique camembert des types de personnels
            function Camembert_type_pers(data, containerId) {
                var ctx = document.getElementById(containerId).getContext('2d');

                if (Chart.getChart(ctx)) {
                    Chart.getChart(ctx).destroy();
                }

                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.map(item => item.label),
                        datasets: [{
                            data: data.map(item => item.value),
                            backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Répartition par type de personnel - Donnée 2021'
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection