@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Principaux établissements de l'enseignement supérieur</h1>
        <div id="filtres" style="display: none;">
            <div class="mb-3 d-flex">
                <input type="text" id="filtreTitle" class="filtreTitle filtre" placeholder="Rechercher un établissement">
                <input type="text" id="filtreCommune" class="filtreCommune filtre" placeholder="Rechercher une commune">
                <div class="filtre-case">
                    <label for="filtreType">Type d'établissement :</label><br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeUniversite" value="Université">
                                <label class="form-check-label" for="typeUniversite">Université</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeEcole" value="École">
                                <label class="form-check-label" for="typeEcole">École</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-check">
                                <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeGrand" value="Grand établissement">
                                <label class="form-check-label" for="typeGrand">Grand établissement</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeAutre" value="Autre établissement">
                                <label class="form-check-label" for="typeAutre">Autre établissement</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filtre-case">
                    <label for="filtreSecteur">Type de secteur :</label><br>
                    <div class="form-check">
                        <input class="form-check-input filtreSecteur" type="checkbox" name="typeSecteur" id="secteurPublic" value="public">
                        <label class="form-check-label" for="secteurPublic">Public</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input filtreSecteur" type="checkbox" name="typeSecteur" id="secteurPrive" value="privé">
                        <label class="form-check-label" for="secteurPrive">Privé</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="btn-group btn-univ" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-table="tableau">Vue Tableau</button>
                    <button type="button" class="btn btn-outline-primary" data-table="graphique">Vue Graphique</button>
                    <button type="button" class="btn btn-outline-primary" data-table="carte">Vue Carte</button>
                </div>
                <div class="btn-group btn-graphique" role="group" id="graphique-options" style="display: none;">
                    <button type="button" class="btn btn-outline-primary active" data-table="TE_Global">TE Global</button>
                    <button type="button" class="btn btn-outline-primary" data-table="TE">TE (Enseignants uniquement)</button>
                </div>

                <div class="table-responsive-univ" id="tableau" style="display: block;">
                    <table id="etablissementsTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Établissement</th>
                                <th style="cursor: pointer;">Catégorie</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Secteur</th>
                                <th style="cursor: pointer;">Étudiants inscrits<sup>1</sup></th>
                                <th style="cursor: pointer;">Effectif Personnels<sup>2</sup></th>
                                <th style="cursor: pointer;">Effectif enseignants</th>
                                <th style="cursor: pointer;">TE<sup>3</sup></th>
                                <th style="cursor: pointer;">TE Global<sup>4</sup></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etablissements as $etablissement)
                                <tr>
                                    <td>{{ $etablissement->id }}</td>
                                    <td><a href="{{ route('etablissements.show', $etablissement) }}" class="text-decoration-none" style="color: inherit;">{{ $etablissement->Etablissement }}</a></td>
                                    <td>{{ $etablissement->Type }}</td>
                                    <td>{{ $etablissement->Commune }}</td>
                                    <td>{{ $etablissement->Secteur }}</td>
                                    <td>{{ $etablissement->etudiants->Effectif_2022 ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Personnels_non_enseignant == 0 ? 'nd' : $etablissement->Personnels_non_enseignant ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Enseignants == 0 ? 'nd' : $etablissement->Enseignants ?? 'nd' }}</td>
                                    <td>{{ $etablissement->TE_enseignants ?? 'nd' }}</td>
                                    <td>{{ $etablissement->TE_Total ?? 'nd' }}</td>
                                    <td><a href="#"><img src="{{ asset('images/fiche.png') }}" class="icone-img" alt="Fiche de l'établissement"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="graphique" style="display: none;">
                    <canvas id="tauxEncadrementChart" width="400" height="170"></canvas>
                </div>
                
                <div id="carte" style="display: none;">
                    <!-- Tu mets la carte juste la -->
                </div>
                
                <div class="row" id="indice">
                    <div class="col-md-2">
                        <p><sup>1</sup> Étudiants inscrits sur l'année 2022-2023</p>
                    </div>
                    <div class="col-md-2">
                        <p><sup>2</sup> Personnels hors enseignants</p>
                    </div>
                    <div class="col-md-3">
                        <p><sup>3</sup> Taux d'encadrement (Enseignants uniquement) pour 1000 étudiants par université</p>
                    </div>
                    <div class="col-md-3">
                        <p><sup>4</sup> Taux d'encadrement (Personnels et Enseignants) pour 1000 étudiants par université</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var etablissements = @json($etablissements);
            var graphiqueInstance = null;
            var table = $('#etablissementsTable').DataTable({
                paging: false,
                ordering: true,
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { render: function (data, type, row) {
                        if (type === 'display') {
                            if (data === 'nd' || data === null || data === 0) {
                                return 'nd';
                            } else {
                                return parseInt(data);
                            }
                        }
                        return data === 'nd' || data === null ? 0 : parseInt(data);
                    }, targets: [5, 6, 7, 8, 9]
                    }
                ],
                dom: 'lrtip',
                language: {
                    "emptyTable": "Aucun résultat trouvé",
                    "zeroRecords": "Aucun résultat trouvé",
                    "info": "Affichage de _TOTAL_ données",
                    "infoFiltered": "(filtré)",
                },
                drawCallback: function() {
                    var api = this.api();
                    var rows = api.rows({page:'current'}).nodes();
                    api.column(0, {page:'current'}).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });

            afficherVue('tableau');

            // Initialisation des vues
            function afficherVue(vue) {
                $('#tableau').hide();
                $('#graphique').hide();
                $('#carte').hide();
                $('#filtres').hide();
                $('#indice').hide();
                $('#graphique-options').hide();
                $('.btn-group.btn-univ button').removeClass('active');
                $(`#${vue}`).show();
                $(`.btn-group.btn-univ button[data-table="${vue}"]`).addClass('active');

                if (vue === 'tableau') {
                    $('#filtres').show();
                    $('#indice').show();
                } else if (vue === 'graphique') {
                    $('#graphique-options').show();
                    dessinerGraphique('TE_Global');
                }
            }

            $('.btn-group.btn-univ button').on('click', function() {
                var vue = $(this).data('table');
                afficherVue(vue);
            });

            $('#graphique-options button').on('click', function() {
                var typeGraphique = $(this).data('table');

                $('#graphique-options button').removeClass('active');

                $(this).addClass('active');

                dessinerGraphique(typeGraphique);
            });

            function dessinerGraphique(typeGraphique) {
                if (graphiqueInstance) {
                    graphiqueInstance.destroy();
                }

                var labels = [];
                var donnees = [];

                etablissements.forEach(function(etablissement) {
                    if (etablissement.Type === 'Université') {
                        labels.push(etablissement.Etablissement);
                        
                        if (typeGraphique === 'TE_Global' && etablissement.TE_Total !== null) {
                            donnees.push(etablissement.TE_Total);
                        } else if (typeGraphique === 'TE' && etablissement.TE_enseignants !== null) {
                            donnees.push(etablissement.TE_enseignants);
                        }
                    }
                });

                // Trier par ordre décroissant
                var donneesTriees = donnees.map(function(valeur, index) {
                    return { valeur: valeur, index: index };
                }).sort(function(a, b) {
                    return b.valeur - a.valeur;
                });

                var labelsTriees = donneesTriees.map(function(item) {
                    return labels[item.index];
                });
                var donneesTriees = donneesTriees.map(function(item) {
                    return item.valeur;
                });

                var ctx = document.getElementById('tauxEncadrementChart').getContext('2d');
                graphiqueInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelsTriees,
                        datasets: [{
                            label: typeGraphique === 'TE_Global' ? 'Taux d\'encadrement total (Personnels + Enseignants) pour 1000 étudiants par Université - Donnée 2021' : 'Taux d\'encadrement enseignants pour 1000 étudiants par Université - Donnée 2021',
                            data: donneesTriees,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'x',
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Filtrage
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var filtreTitre = $('#filtreTitle').val().toLowerCase();
                    var filtreCommune = $('#filtreCommune').val().toLowerCase();
                    var filtresTypes = $('.filtreType:checked').map(function() {
                        return $(this).val().toLowerCase();
                    }).get();
                    var filtresSecteurs = $('.filtreSecteur:checked').map(function() {
                        return $(this).val().toLowerCase();
                    }).get();

                    var etablissement = data[1].toLowerCase();
                    var commune = data[3].toLowerCase();
                    var type = data[2].toLowerCase();
                    var secteur = data[4].toLowerCase();

                    var correspondTitre = filtreTitre === '' || etablissement.includes(filtreTitre);
                    var correspondCommune = filtreCommune === '' || commune.includes(filtreCommune);
                    var correspondType = filtresTypes.length === 0 || filtresTypes.includes(type);
                    var correspondSecteur = filtresSecteurs.length === 0 || filtresSecteurs.includes(secteur);

                    return correspondTitre && correspondCommune && correspondType && correspondSecteur;
                }
            );

            $('#filtreTitle, #filtreCommune').on('input', function() {
                table.draw();
            });
            $('.filtreType, .filtreSecteur').on('change', function() {
                table.draw();
            });
        });
   </script>

@endsection