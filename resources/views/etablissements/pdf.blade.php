<!DOCTYPE html>
<html>
<head>
    <title>Fiche de l'établissement {{ $etablissement->Etablissement }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .Etab {
            margin-left: 10%;
            font-style: italic;
        }
        h2 {
            text-align: center;
            margin-top: 7%;
            margin-bottom: 3%;
        }
        p,.discipline {
            margin-left: 25%;
        }
        .en_Gras {
            font-weight: bold;
        }
        .lien {
            text-decoration: none;
        }
        .tableaux {
            display: flex;
        }
        .Titre_Table {
            background-color: #274CFF;
            color: white;
            padding: 10px;
        }
        .table tbody tr:nth-child(even) {
            background-color: white;
            color: dark;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #000038;
            color: white;
        }
        table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .sites {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <h1>Détails de l'établissement :</h1>
    <h1 class="Etab">{{ $etablissement->Etablissement }}</h1>

    <!-- SECTION informations generales -->
    <h2 class="soustitre">Informations Générales</h2>
    <div>
        <p><span>Type d'établissement :</span> <span class="en_Gras">{{ $etablissement->Type }}</span></p>
        <p><span>Secteur :</span> <span class="en_Gras">{{ $etablissement->Secteur }}</span></p>
        <p><span>Commune :</span> <span class="en_Gras">{{ $etablissement->Commune }}</span></p>
        <p><span>Département :</span> <span class="en_Gras">{{ $etablissement->Departement }}</span></p>
        <p><span>Région :</span> <span class="en_Gras">{{ $etablissement->Region }}</span></p>
        <p><span>Académie :</span> <span class="en_Gras">{{ $etablissement->Academie }}</span></p>
        @if ($etablissement->Adresse)
            <p><span>Adresse :</span> <span class="en_Gras">{{ $etablissement->Adresse }}</span></p>
        @endif
        @if ($etablissement->date_creation)
            <p><span>Date de création :</span> <span class="en_Gras">{{ $etablissement->date_creation }}</span></p>
        @endif
        @if ($etablissement->contact)
            <p><span>Numéro de Téléphone :</span> <span class="en_Gras">{{ $etablissement->contact }}</span></p>
        @endif
    </div>

    <!-- SECTION sites internet -->
    @if ($etablissement->url || $etablissement->Wikipedia || $etablissement->facebook || $etablissement->twitter || $etablissement->instagram || $etablissement->linkedin)
        <h2 class="soustitre">Site Internet et Liens Sociaux</h2>
        <div class="sites">
            @if ($etablissement->url)
                <p><span>Site Internet :</span> <span><a href="{{ $etablissement->url }}" class="lien">{{ $etablissement->url }}</a></span></p>
            @endif
            @if ($etablissement->Wikipedia)
                <p><span>Wikipedia :</span> <span><a href="{{ $etablissement->Wikipedia }}" class="lien">{{ $etablissement->Etablissement }}</a></span></p>
            @endif
            @if ($etablissement->facebook)
                <p><span>Facebook :</span> <span><a href="{{ $etablissement->facebook }}" class="lien">{{ $etablissement->Etablissement }}</a></span></p>
            @endif
            @if ($etablissement->twitter)
                <p><span>Twitter :</span> <span><a href="{{ $etablissement->twitter }}" class="lien">{{ $etablissement->Etablissement }}</a></span></p>
            @endif
            @if ($etablissement->instagram)
                <p><span>Instagram :</span> <span><a href="{{ $etablissement->instagram }}" class="lien">{{ $etablissement->Etablissement }}</a></span></p>
            @endif
            @if ($etablissement->linkedin)
                <p><span>Linkedin :</span> <span><a href="{{ $etablissement->linkedin }}" class="lien">{{ $etablissement->Etablissement }}</a></span></p>
            @endif
        </div>
    @endif

    <!-- SECTION autres informations -->
    <div>
        <h2 class="soustitre">Autres Informations</h2>
        <div>
            <p><span>Donnée de Géolocalisation :</span> <span class="en_Gras">{{ $etablissement->lon }},{{ $etablissement->lat }}</span></p>
            @if ($etablissement->siret)
                <p><span>Numéro de Siret :</span> <span class="en_Gras">{{ $etablissement->siret }}</span></p>
            @endif
        </div>
    </div><br>

    <!--Tableau des Effectifs des Étudiants par Année-->
    @if (($etablissement->etudiants->Effectif_2022) || ($etablissement->etudiants->Effectif_2021) || ($etablissement->etudiants->Effectif_2020) || ($etablissement->etudiants->Effectif_2019) || ($etablissement->etudiants->Effectif_2018) || ($etablissement->etudiants->Effectif_2017) || ($etablissement->etudiants->Effectif_2016) || ($etablissement->etudiants->Effectif_2015) || ($etablissement->etudiants->Effectif_2014) || ($etablissement->etudiants->Effectif_2013))
        <h2 class="sousTitre">Effectifs des Étudiants par Année</h2>
        <table class="table" style="margin-left: 30%">
            <thead>
                <tr>
                    <th class="Titre_Table">Année</th>
                    <th class="Titre_Table">Nombre d'étudiants inscrits</th>
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
    @endif

    <!-- Tableau du nombre de enseignants -->
    @if ($etablissement->enseignants->isNotEmpty())
        <h2 class="soustitre">Les Enseignants</h2>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th class="Titre_Table">Effectif Total</th>
                    <th class="Titre_Table">Effectif Homme</th>
                    <th class="Titre_Table">Effectif Femme</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="Titre_Table">Enseignants du 2nd degré et Arts et métiers</th>
                    @php
                        $arts = $etablissement->enseignants->where('Type', 'Enseignants du 2nd degré et Arts et métiers')->first();
                    @endphp
                    <td>{{ $arts->Effectif ?? 'nd' }}</td>
                    <td>{{ $arts->Effectif_H ?? 'nd' }}</td>
                    <td>{{ $arts->Effectif_F ?? 'nd' }}</td>
                </tr>
                <tr>
                    <th class="Titre_Table">Maître de conférences et assimilés</th>
                    @php
                        $conference = $etablissement->enseignants->where('Type', 'Maître de conférences et assimilés')->first();
                    @endphp
                    <td>{{ $conference->Effectif ?? 'nd' }}</td>
                    <td>{{ $conference->Effectif_H ?? 'nd' }}</td>
                    <td>{{ $conference->Effectif_F ?? 'nd' }}</td>
                </tr>
                <tr>
                    <th class="Titre_Table">Professeur et assimilés</th>
                    @php
                        $prof = $etablissement->enseignants->where('Type', 'Professeur et assimilés')->first();
                    @endphp
                    <td>{{ $prof->Effectif ?? 'nd' }}</td>
                    <td>{{ $prof->Effectif_H ?? 'nd' }}</td>
                    <td>{{ $prof->Effectif_F ?? 'nd' }}</td>
                </tr>
                <tr>
                    <th class="Titre_Table">Total</th>
                    <td>{{ ($arts->Effectif ?? 0) + ($conference->Effectif ?? 0) + ($prof->Effectif ?? 0) }}</td>
                    <td>{{ ($arts->Effectif_H ?? 0) + ($conference->Effectif_H ?? 0) + ($prof->Effectif_H ?? 0) }}</td>
                    <td>{{ ($arts->Effectif_F ?? 0) + ($conference->Effectif_F ?? 0) + ($prof->Effectif_F ?? 0) }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <!-- Tableau du nombre de personnel -->
    @if ($etablissement->personnels->isNotEmpty())
        <h2 class="soustitre">Le Personnel</h2>
        <table class="table" style="margin-left: 10%">
            <thead>
                <tr>
                    <th></th>
                    <th class="Titre_Table">Effectif Total</th>
                    <th class="Titre_Table">Effectif Homme</th>
                    <th class="Titre_Table">Effectif Femme</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="Titre_Table">Titulaires</th>
                    @php
                        $titulaires = $etablissement->personnels->where('Type', 'titulaires')->first();
                    @endphp
                    <td>{{ $titulaires->Effectif ?? 'nd' }}</td>
                    <td>{{ $titulaires->Effectif_H ?? 'nd' }}</td>
                    <td>{{ $titulaires->Effectif_F ?? 'nd' }}</td>
                </tr>
                <tr>
                    <th class="Titre_Table">Contractuels</th>
                    @php
                        $contractuels = $etablissement->personnels->where('Type', 'contractuels')->first();
                    @endphp
                    <td>{{ $contractuels->Effectif ?? 'nd' }}</td>
                    <td>{{ $contractuels->Effectif_H ?? 'nd' }}</td>
                    <td>{{ $contractuels->Effectif_F ?? 'nd' }}</td>
                </tr>
                <tr>
                    <th class="Titre_Table">Total</th>
                    <td>{{ $etablissement->Personnels_non_enseignant ?? 'nd' }}</td>
                    <td>{{ $etablissement->Personnels_non_enseignant_H ?? 'nd' }}</td>
                    <td>{{ $etablissement->Personnels_non_enseignant_F ?? 'nd' }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <!-- Liste des disciplines -->
    @if ($etablissement->disciplines->isNotEmpty())
        <h2 class="soustitre">Les Disciplines enseignées</h2>
        <div class="discipline">
            <ul>
                @foreach ($etablissement->disciplines as $discipline)
                    @php
                        $disciplineList = explode('//', $discipline->Discipline);
                    @endphp
                    @foreach ($disciplineList as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>