@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Principaux établissements de l'enseignement supérieur</h1>
        <div id="filtres" style="display: none;">
            <div class="mb-3 d-flex">
                <input type="text" id="filtreNom" class="filtreNom filtre" placeholder="Rechercher un établissement">
                <input type="text" id="filtreVille" class="filtreVille filtre" placeholder="Rechercher une ville">
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
                    <button type="button" class="btn btn-outline-primary active" data-vue="tableau">Vue Tableau</button>
                    <button type="button" class="btn btn-outline-primary" data-vue="graphique">Vue Graphique</button>
                    <button type="button" class="btn btn-outline-primary" data-vue="carte">Vue Carte</button>
                </div>
                <div class="btn-group btn-graphique" role="group" id="graphique-options" style="display: none;">
                    <button type="button" class="btn btn-outline-primary" data-vue="effectif_E">Effectif etudiant</button>
                    <button type="button" class="btn btn-outline-primary" data-vue="TE_Global">TE Global</button>
                    <button type="button" class="btn btn-outline-primary" data-vue="TE">TE (Enseignants uniquement)</button>
                    <!--<button type="button" class="btn btn-outline-primary" data-vue="TI_Licence">TI en Licence Pro</button>
                    <button type="button" class="btn btn-outline-primary" data-vue="TI_Master">TI en Master LMD/ENS</button>-->
                    <button type="button" class="btn btn-outline-primary" data-vue="secteur">Secteur Public/Privé</button>
                </div>

                <div class="table-responsive-univ" id="tableau" style="display: block;">
                    <table id="etablissementsTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Établissement</th>
                                <th style="cursor: pointer;">Catégorie</th>
                                <th style="cursor: pointer;">Ville</th>
                                <th style="cursor: pointer;">Secteur</th>
                                <th style="cursor: pointer;">Étudiants inscrits<sup>1</sup></th>
                                <th style="cursor: pointer;">Effectif Personnels<sup>2</sup></th>
                                <th style="cursor: pointer;">Effectif enseignants</th>
                                <th style="cursor: pointer;">TE<sup>3</sup></th>
                                <th style="cursor: pointer;">TE Global<sup>4</sup></th>
                                <th style="cursor: pointer;">TI Licence Pro<sup>5</sup></th>
                                <th style="cursor: pointer;">TI Master<sup>6</sup></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etablissements as $etab)
                                <tr>
                                    <td>{{ $etab->id }}</td>
                                    <td><a href="{{ route('etablissements.show', $etab) }}" class="text-decoration-none" style="color: inherit;">{{ $etab->Etablissement }}</a></td>
                                    <td>{{ $etab->Type }}</td>
                                    <td>{{ $etab->Commune }}</td>
                                    <td>{{ $etab->Secteur }}</td>
                                    <td>{{ $etab->etudiants->Effectif_2022 ?? 'nd' }}</td>
                                    <td>{{ $etab->Personnels_non_enseignant == 0 ? 'nd' : $etab->Personnels_non_enseignant ?? 'nd' }}</td>
                                    <td>{{ $etab->Enseignants == 0 ? 'nd' : $etab->Enseignants ?? 'nd' }}</td>
                                    <td>{{ $etab->TE_enseignants ?? 'nd' }}</td>
                                    <td>{{ $etab->TE_Total ?? 'nd' }}</td>
                                    <td>{{ $etab->insertions->inser_Licence ?? 'nd' }}</td>
                                    <td>{{ $etab->insertions->inser_Master ?? 'nd' }}</td>
                                    <td><a href="#"><img src="{{ asset('images/fiche.png') }}" class="icone-img" alt="Fiche de l'établissement"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="graphique" style="display: none;">
                    <canvas id="tauxEncadrementChart" width="400" height="170"></canvas>
                </div>

                <div id="graphiqueSecteursContainer" style="display: none;">
                    <canvas id="graphiqueSecteursChart" width="1300" height="700"></canvas>
                </div>
                
                <div id="carte" style="display: none;">
                    <!-- Tu mets la carte juste la -->
                </div>
                
                <div id="indice">
                    <div class="row">
                        <div class="col-md-2">
                            <span><sup>1</sup> Étudiants inscrits à la rentrée 2022</span>
                        </div>
                        <div class="col-md-2">
                            <span><sup>2</sup> Personnels hors enseignants à la rentrée 2022</span>
                        </div>
                        <div class="col-md-4">
                            <span><sup>3</sup> Taux d'encadrement (Enseignants uniquement) pour 1000 étudiants par université</span>
                        </div>
                        <div class="col-md-4">
                            <span><sup>4</sup> Taux d'encadrement (Personnels et Enseignants) pour 1000 étudiants par université</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <span><sup>5</sup> Taux d'insertion 18 mois apres le diplome en Licence Professionnel en 2020</span>
                        </div>
                        <div class="col-md-6">
                            <span><sup>6</sup> Taux d'insertion 18 mois apres le diplome en Master LMD/ENS en 2020</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var etabs = @json($etablissements);
            var graphInstance = null;
            var graphSecteurInstance = null;
            var currentGraphType = 'effectif_E';
            var table = $('#etablissementsTable').DataTable({
                paging: false,
                ordering: true,
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { 
                        render: function (data, type, row) {
                            if (type === 'display') {
                                if (data === 'nd' || data === null || data === 0) {
                                    return 'nd';
                                } else {
                                    return parseInt(data);
                                }
                            }
                            return data === 'nd' || data === null ? 0 : parseInt(data);
                        }, 
                        targets: [5, 6, 7, 8, 9]
                    },
                    { 
                        render: function (data, type, row) {
                            if (type === 'display') {
                                if (data === 'nd' || data === null || data === 0) {
                                    return 'nd';
                                } else {
                                    return parseFloat(data).toFixed(1);
                                }
                            }
                            return data === 'nd' || data === null ? 0 : parseFloat(data);
                        },
                        targets: [10, 11]
                    }
                ],
                dom: 'lrtip',
                language: {
                    "emptyTable": "Aucun résultat trouvé",
                    "zeroRecords": "Aucun résultat trouvé",
                    "info": "Affichage de _TOTAL_ données",
                    "infoEmpty": "Aucun résultat trouvé",
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

            function afficherVue(vue) {
                $('#tableau').hide();
                $('#graphique').hide();
                $('#carte').hide();
                $('#filtres').hide();
                $('#indice').hide();
                $('#graphique-options').hide();
                $('#graphiqueSecteursContainer').hide();
                $('.btn-group.btn-univ button').removeClass('active');
                $(`#${vue}`).show();
                $(`.btn-group.btn-univ button[data-vue="${vue}"]`).addClass('active');

                if (vue === 'tableau') {
                    $('#filtres').show();
                    $('#indice').show();
                } else if (vue === 'graphique') {
                    $('#graphique-options').show();
                    $('#graphique-options button').removeClass('active');
                    $(`#graphique-options button[data-vue="${currentGraphType}"]`).addClass('active');
                    dessinerGraphique(currentGraphType);
                }
            }

            $('.btn-group.btn-univ button').on('click', function() {
                var vue = $(this).data('vue');
                afficherVue(vue);
            });

            $('#graphique-options button').on('click', function() {
                var typeGraphique = $(this).data('vue');
                currentGraphType = typeGraphique;

                $('#graphique-options button').removeClass('active');
                $(this).addClass('active');

                if (typeGraphique === 'secteur') {
                    $('#graphique').hide();
                    $('#graphiqueSecteursContainer').show();
                    dessinerGraphiqueSecteurs();
                } else {
                    $('#graphiqueSecteursContainer').hide();
                    $('#graphique').show();
                    dessinerGraphique(typeGraphique);
                }
            });

            function dessinerGraphique(typeGraphique) {
                if (graphInstance) {
                    graphInstance.destroy();
                }

                var labels = [];
                var donnees = [];

                etabs.forEach(function (etab) {
                    if (etab.Type === 'Université') {
                        labels.push(etab.Etablissement);

                        if (typeGraphique === 'TE_Global' && etab.TE_Total !== null) {
                            donnees.push(etab.TE_Total);
                        } else if (typeGraphique === 'TE' && etab.TE_enseignants !== null) {
                            donnees.push(etab.TE_enseignants);
                        } else if (typeGraphique === 'effectif_E' && etab.etudiants && etab.etudiants.Effectif_2022 !== null) {
                            donnees.push(etab.etudiants.Effectif_2022);
                        }
                    }
                });

                var donneesTriees = donnees.map(function (valeur, index) {
                    return { valeur: valeur, index: index };
                }).sort(function (a, b) {
                    return b.valeur - a.valeur;
                });

                var labelsTriees = donneesTriees.map(function (item) {
                    return labels[item.index];
                });
                var donneesTriees = donneesTriees.map(function (item) {
                    return item.valeur;
                });

                var ctx = document.getElementById('tauxEncadrementChart').getContext('2d');
                graphInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelsTriees,
                        datasets: [{
                            label: typeGraphique === 'TE_Global' ? 'Taux d\'encadrement total (Personnels + Enseignants) pour 1000 étudiants par Université - Donnée 2021' : typeGraphique === 'TE' ? 'Taux d\'encadrement enseignants pour 1000 étudiants par Université - Donnée 2021' : 'Effectif des étudiants par Université - Donnée 2022',
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

            function dessinerGraphiqueSecteurs() {
                if (graphSecteurInstance) {
                    graphSecteurInstance.destroy();
                }

                var etabsPublics = etabs.filter(function(etab) {
                    return etab.Secteur.toLowerCase() === 'public';
                }).length;

                var etabsPrives = etabs.filter(function(etab) {
                    return etab.Secteur.toLowerCase() === 'privé';
                }).length;

                var totalEtabs = etabsPublics + etabsPrives;
                var pourcentagePublics = (etabsPublics / totalEtabs) * 100;
                var pourcentagePrives = (etabsPrives / totalEtabs) * 100;

                var ctx = document.getElementById('graphiqueSecteursChart').getContext('2d');
                graphSecteurInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Public', 'Privé'],
                        datasets: [{
                            data: [pourcentagePublics, pourcentagePrives],
                            backgroundColor: ['#36A2EB', '#FF6384']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Répartition des établissements entre les secteurs public et privé (en %)'
                            }
                        }
                    }
                });
            }

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var filtreNom = $('#filtreNom').val().toLowerCase();
                    var filtreVille = $('#filtreVille').val().toLowerCase();
                        var filtresTypes = $('.filtreType:checked').map(function() {
                        return $(this).val().toLowerCase();
                        }).get();
                        var filtresSecteurs = $('.filtreSecteur:checked').map(function() {
                        return $(this).val().toLowerCase();
                        }).get();
                        var etablissement = data[1].toLowerCase();
                        var ville = data[3].toLowerCase();
                        var type = data[2].toLowerCase();
                        var secteur = data[4].toLowerCase();

                        var correspondNom = filtreNom === '' || etablissement.includes(filtreNom);
                        var correspondVille = filtreVille === '' || ville.includes(filtreVille);
                        var correspondType = filtresTypes.length === 0 || filtresTypes.includes(type);
                        var correspondSecteur = filtresSecteurs.length === 0 || filtresSecteurs.includes(secteur);

                        return correspondNom && correspondVille && correspondType && correspondSecteur;
                }
            );

            $('#filtreNom, #filtreVille').on('input', function() {
                table.draw();
            });
            $('.filtreType, .filtreSecteur').on('change', function() {
                table.draw();
            });
        });
    </script>
@endsection