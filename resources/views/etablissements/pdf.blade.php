<!DOCTYPE html>
<html>
<head>
    <title>Mon PDF</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .text-center {
            text-align: center;
        }
        .text-decoration-none {
            text-decoration: none;
        }
        .mt-5 {
            margin-top: 2em;
        }
        .mb-4 {
            margin-bottom: 1.5em;
        }
        .mb-5 {
            margin-bottom: 2em;
        }
        .p-3 {
            padding: 1em;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 0.5em;
            text-align: center;
        }
        .text-white {
            color: #fff;
        }
        .bg-blue {
            background-color: #3f32ec;
        }
        .d-flex{
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    @php
        ini_set('max_execution_time', 0);
    @endphp

    <div class="container-fluid">
        <h1>Détails de l'établissement :</h1>
        <h1 class="mb-5 ml-4">{{ $etablissement->Etablissement }}</h1>

        <div class="row justify-content-around">
            <!-- SECTION informations generales -->
            <div class="col-md-6">
                <h2 class="text-center mt-5 mb-4">Informations Générales</h2>
                <div class="ml-3">
                    <p><span>Type d'établissement :</span> <span>{{ $etablissement->Type }}</span></p>
                    <p><span>Secteur :</span> <span>{{ $etablissement->Secteur }}</span></p>
                    <p><span>Commune :</span> <span>{{ $etablissement->Commune }}</span></p>
                    <p><span>Département :</span> <span>{{ $etablissement->Departement }}</span></p>
                    <p><span>Région :</span> <span>{{ $etablissement->Region }}</span></p>
                    <p><span>Académie :</span> <span>{{ $etablissement->Academie }}</span></p>
                    @if ($etablissement->Adresse)
                        <p><span>Adresse :</span> <span>{{ $etablissement->Adresse }}</span></p>
                    @endif
                    @if ($etablissement->date_creation)
                        <p><span>Date de création :</span> <span>{{ $etablissement->date_creation }}</span></p>
                    @endif
                    @if ($etablissement->contact)
                        <p><span>Numéro de Téléphone :</span> <span>{{ $etablissement->contact }}</span></p>
                    @endif
                </div>
            </div>

            <!-- SECTION sites internet -->
            <div class="col-md-6">
                @if ($etablissement->url || $etablissement->Wikipedia || $etablissement->facebook || $etablissement->twitter || $etablissement->instagram || $etablissement->linkedin)
                    <h2 class="text-center mt-5 mb-4">Site Internet et Liens Sociaux</h2>
                    <div class="ml-3">
                        @if ($etablissement->url)
                            <p><span>Site Internet :</span> <span><a href="{{ $etablissement->url }}" class="text-decoration-none">{{ $etablissement->Etablissement }}</a></span></p>
                        @endif
                        @if ($etablissement->Wikipedia)
                            <p><span>Wikipedia :</span> <span><a href="{{ $etablissement->Wikipedia }}" class="text-decoration-none">Page Wikipedia</a></span></p>
                        @endif
                        @if ($etablissement->facebook)
                            <p><span>Facebook :</span> <span><a href="{{ $etablissement->facebook }}" class="text-decoration-none">Page Facebook</a></span></p>
                        @endif
                        @if ($etablissement->twitter)
                            <p><span>Twitter :</span> <span><a href="{{ $etablissement->twitter }}" class="text-decoration-none">Page Twitter</a></span></p>
                        @endif
                        @if ($etablissement->instagram)
                            <p><span>Instagram :</span> <span><a href="{{ $etablissement->instagram }}" class="text-decoration-none">Page Instagram</a></span></p>
                        @endif
                        @if ($etablissement->linkedin)
                            <p><span>Linkedin :</span> <span><a href="{{ $etablissement->linkedin }}" class="text-decoration-none">Page Linkedin</a></span></p>
                        @endif
                    </div>
                @endif

                <!-- SECTION autres informations -->
                <div>
                    <h2 class="text-center mt-5 mb-4">Autres Informations</h2>
                    <div>
                        <p><span>Donnée de Géolocalisation :</span> <span>{{ $etablissement->lon }},{{ $etablissement->lat }}</span></p>
                        @if ($etablissement->siret)
                            <p><span>Numéro de Siret :</span> <span>{{ $etablissement->siret }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center flex-wrap">

            <!-- Tableau du nombre de enseignants -->
            @if ($etablissement->enseignants->isNotEmpty())
                <div class="col-md-4 p-3">
                    <h2 class="text-center mt-5 mb-4">Les Enseignants</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Effectif Total</th>
                                <th>Effectif Homme</th>
                                <th>Effectif Femme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="bg-blue text-white">Enseignants du 2nd degré et Arts et métiers</th>
                                @php
                                    $arts = $etablissement->enseignants->where('Type', 'Enseignants du 2nd degré et Arts et métiers')->first();
                                @endphp
                                <td>{{ $arts->Effectif ?? 'nd' }}</td>
                                <td>{{ $arts->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $arts->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-blue text-white">Maître de conférences et assimilés</th>
                                @php
                                    $conference = $etablissement->enseignants->where('Type', 'Maître de conférences et assimilés')->first();
                                @endphp
                                <td>{{ $conference->Effectif ?? 'nd' }}</td>
                                <td>{{ $conference->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $conference->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-blue text-white">Professeur et assimilés</th>
                                @php
                                    $prof = $etablissement->enseignants->where('Type', 'Professeur et assimilés')->first();
                                @endphp
                                <td>{{ $prof->Effectif ?? 'nd' }}</td>
                                <td>{{ $prof->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $prof->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th class="bg-blue text-white">Total</th>
                                    <td>{{ ($arts->Effectif ?? 0) + ($conference->Effectif ?? 0) + ($prof->Effectif ?? 0) }}</td>
                                    <td>{{ ($arts->Effectif_H ?? 0) + ($conference->Effectif_H ?? 0) + ($prof->Effectif_H ?? 0) }}</td>
                                    <td>{{ ($arts->Effectif_F ?? 0) + ($conference->Effectif_F ?? 0) + ($prof->Effectif_F ?? 0) }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            @endif


            <!-- Tableau du nombre de personnel -->
            @if ($etablissement->personnels->isNotEmpty())
                <div class="col-md-4 p-3">
                    <h2 class="text-center mt-5 mb-4">Le Personnel</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Effectif Total</th>
                                <th>Effectif Homme</th>
                                <th>Effectif Femme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="bg-blue text-white">Titulaires</th>
                                @php
                                    $titulaires = $etablissement->personnels->where('Type', 'titulaires')->first();
                                @endphp
                                <td>{{ $titulaires->Effectif ?? 'nd' }}</td>
                                <td>{{ $titulaires->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $titulaires->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-blue text-white">Contractuels</th>
                                @php
                                    $contractuels = $etablissement->personnels->where('Type', 'contractuels')->first();
                                @endphp
                                <td>{{ $contractuels->Effectif ?? 'nd' }}</td>
                                <td>{{ $contractuels->Effectif_H ?? 'nd' }}</td>
                                <td>{{ $contractuels->Effectif_F ?? 'nd' }}</td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th class="bg-blue text-white">Total</th>
                                    <td>{{ $etablissement->Personnels_non_enseignant ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Personnels_non_enseignant_H ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Personnels_non_enseignant_F ?? 'nd' }}</td>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        <!-- Liste des disciplines -->
        @if ($etablissement->disciplines->isNotEmpty())
            <h2 class="text-center mt-5 mb-4">Les Disciplines enseignées</h2>
            <div class="row d-flex justify-content-center">
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
    </div>
</body>
</html>
