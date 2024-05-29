@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Autres Statistiques</h1>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="mb-3 d-flex">
                    <input type="text" id="filtreTitle" class="filtreTitle filtre-stat" placeholder="Rechercher un établissement">
                    <input type="text" id="filtreCommune" class="filtreCommune filtre-stat" placeholder="Rechercher une commune">
                </div>
                <div class="btn-group btn-stat" role="group">
                    <button type="button" class="btn btn-outline-primary" data-table="genre-table">sur les effectifs étudiant</button>
                    <button type="button" class="btn btn-outline-primary" data-table="inscrits-table">sur les inscriptions</button>
                    <button type="button" class="btn btn-outline-primary" data-table="baccalaureat-table">sur les baccalauréats</button>
                    <button type="button" class="btn btn-outline-primary" data-table="mobilite-table">sur la mobilité</button>
                    <button type="button" class="btn btn-outline-primary" data-table="GD-table">sur les Grandes Disciplines</button>
                    <button type="button" class="btn btn-outline-primary" data-table="Disc-table">sur les Disciplines</button>
                </div>

                <div class="table-responsive-stat">
                    <!-- TABLEAU SUR LES ETUDIANTS -->
                    <table id="EtudiantTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Rentrée</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Effectif etudiants</th>
                                <th style="cursor: pointer;">Homme</th>
                                <th style="cursor: pointer;">Femme</th>
                                <th style="cursor: pointer;">Niveau BAC+4</th>
                                <th style="cursor: pointer;">Niveau BAC+5</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistiques as $statistique)
                                <tr>
                                    <td>{{ $statistique->id }}</td>
                                    <td>{{ $statistique->rentree }}</td>
                                    <td>{{ $statistique->etablissement->Etablissement }}</td>
                                    <td>{{ $statistique->etablissement->Commune }}</td>
                                    <td>{{ $statistique->Etudiants_inscrits }}</td>
                                    <td>{{ $statistique->Etudiants_inscrits_H }}</td>
                                    <td>{{ $statistique->Etudiants_inscrits_F }}</td>
                                    <td>{{ $statistique->Bac4 }}</td>
                                    <td>{{ $statistique->Bac5 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- TABLEAU SUR LES BAC -->
                    <table id="BacTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Rentrée</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Effectif etudiants</th>
                                <th style="cursor: pointer;">BAC Général</th>
                                <th style="cursor: pointer;">BAC STMG</th>
                                <th style="cursor: pointer;">BAC : Autres series technologiques</th>
                                <th style="cursor: pointer;">BAC PRO</th>
                                <th style="cursor: pointer;">BAC Dispense</th>
                                <th style="cursor: pointer;">En avance <sup>1</sup></th>
                                <th style="cursor: pointer;">A l'heure</th>
                                <th style="cursor: pointer;">En retard <sup>2</sup></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistiques as $statistique)
                                <tr>
                                    <td>{{ $statistique->id }}</td>
                                    <td>{{ $statistique->rentree }}</td>
                                    <td>{{ $statistique->etablissement->Etablissement }}</td>
                                    <td>{{ $statistique->etablissement->Commune }}</td>
                                    <td>{{ $statistique->Etudiants_inscrits }}</td>
                                    <td>{{ $statistique->Bac_Gen }}</td>
                                    <td>{{ $statistique->Bac_STMG }}</td>
                                    <td>{{ $statistique->Bac_Autre }}</td>
                                    <td>{{ $statistique->Bac_PRO }}</td>
                                    <td>{{ $statistique->Bac_Dispense }}</td>
                                    <td>{{ $statistique->Avance_bac }}</td>
                                    <td>{{ $statistique->Alheure_bac }}</td>
                                    <td>{{ $statistique->Retard_bac }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <!-- TABLEAU SUR LA MOBILITE -->
                    <table id="MobiliteTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Rentrée</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Effectif etudiants</th>
                                <th style="cursor: pointer;">Etudiants en mobilité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistiques as $statistique)
                                <tr>
                                    <td>{{ $statistique->id }}</td>
                                    <td>{{ $statistique->rentree }}</td>
                                    <td>{{ $statistique->etablissement->Etablissement }}</td>
                                    <td>{{ $statistique->etablissement->Commune }}</td>
                                    <td>{{ $statistique->Etudiants_inscrits }}</td>
                                    <td>{{ $statistique->Etudiants_mobilite }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <!-- TABLEAU SUR LES ETUDIANTS INSCRIS-->
                    <table id="InscritsTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Secteur</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Etudiants inscrits en 2018</th>
                                <th style="cursor: pointer;">Etudiants inscrits en 2019</th>
                                <th style="cursor: pointer;">Etudiants inscrits en 2020</th>
                                <th style="cursor: pointer;">Etudiants inscrits en 2021</th>
                                <th style="cursor: pointer;">Etudiants inscrits en 2022</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etablissements as $etablissement)
                                <tr>
                                    <td>{{ $etablissement->id }}</td>
                                    <td>{{ $etablissement->Secteur }}</td>
                                    <td>{{ $etablissement->Etablissement }}</td>
                                    <td>{{ $etablissement->Commune }}</td>
                                    <td>{{ $etablissement->Etudiants_inscrits_2018 ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Etudiants_inscrits_2019 ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Etudiants_inscrits_2020 ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Etudiants_inscrits_2021 ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Etudiants_inscrits_2022 ?? 'nd' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- TABLEAU SUR LES GRANDES DISCIPLINES -->
                    <table id="GDTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Rentrée</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Droit, sciences économiques</th>
                                <th style="cursor: pointer;">Lettres, langues et sciences humaines</th>
                                <th style="cursor: pointer;">Sciences et sciences de l'ingénieur</th>
                                <th style="cursor: pointer;">STAPS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistiques as $statistique)
                                <tr>
                                    <td>{{ $statistique->id }}</td>
                                    <td>{{ $statistique->rentree }}</td>
                                    <td>{{ $statistique->etablissement->Etablissement }}</td>
                                    <td>{{ $statistique->etablissement->Commune }}</td>
                                    <td>{{ $statistique->G_Droit }}</td>
                                    <td>{{ $statistique->G_Lettre_langues }}</td>
                                    <td>{{ $statistique->G_Science_inge }}</td>
                                    <td>{{ $statistique->G_STAPS }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- TABLEAU SUR LES DISCIPLINES -->
                    <table id="Disc-table" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Rentrée</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Sciences économiques, Gestion</th>
                                <th style="cursor: pointer;">Lettres, Sciences du langage, Arts</th>
                                <th style="cursor: pointer;">Langues</th>
                                <th style="cursor: pointer;">Sciences humaines et sociales</th>
                                <th style="cursor: pointer;">Sciences de la vie, de la terre et de l'univers</th>
                                <th style="cursor: pointer;">Sciences fondamentales et applications</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistiques as $statistique)
                                <tr>
                                    <td>{{ $statistique->id }}</td>
                                    <td>{{ $statistique->rentree }}</td>
                                    <td>{{ $statistique->etablissement->Etablissement }}</td>
                                    <td>{{ $statistique->etablissement->Commune }}</td>
                                    <td>{{ $statistique->Science_eco }}</td>
                                    <td>{{ $statistique->lettre_science }}</td>
                                    <td>{{ $statistique->Langue }}</td>
                                    <td>{{ $statistique->Science_hu }}</td>
                                    <td>{{ $statistique->Science_vie }}</td>
                                    <td>{{ $statistique->Science_Fo }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="bac-info" class="row">
                    <div class="col-md-2 mt-2">
                        <p><sup>1</sup> En avance au bac d'un an ou plus</p>
                    </div>
                    <div class="col-md-2 mt-2">
                        <p><sup>2</sup> En retard au bac d'un an ou plus</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
        // Fonction pour initialiser une DataTable avec des options communes
        function initialiserTable(tableId) {
            return $('#' + tableId).DataTable({
                paging: false,
                ordering: true,
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: 0 },
                ],
                dom: 'lrtip',
                language: {
                    "emptyTable": "Aucun résultat trouvé",
                    "zeroRecords": "Aucun résultat trouvé",
                    "info": "",
                    "infoEmpty": "",
                    "infoFiltered": "",
                },
                drawCallback: function() {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    api.column(0, { page: 'current' }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });
        }

        // Initialisation des DataTables
        var etudiantTable = initialiserTable('EtudiantTable');
        var bacTable = initialiserTable('BacTable');
        var mobiliteTable = initialiserTable('MobiliteTable');
        var inscritsTable = initialiserTable('InscritsTable');
        var GDTable = initialiserTable('GDTable');
        var DiscTable = initialiserTable('Disc-table');

        // Filtrage des données
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var filtreTitle = $('#filtreTitle').val().toLowerCase();
                var filtreCommune = $('#filtreCommune').val().toLowerCase();

                var etablissement = data[2].toLowerCase();
                var commune = data[3].toLowerCase();

                var matchesTitle = filtreTitle === '' || etablissement.includes(filtreTitle);
                var matchesCommune = filtreCommune === '' || commune.includes(filtreCommune);

                return matchesTitle && matchesCommune;
            }
        );

        $('#filtreTitle, #filtreCommune').on('input', function() {
            etudiantTable.draw();
            bacTable.draw();
            mobiliteTable.draw();
            inscritsTable.draw();
            GDTable.draw();
            DiscTable.draw();
        });

        // Gestion des boutons de sélection des tableaux
        const buttons = document.querySelectorAll('.btn-group.btn-stat button');

        const tables = {
            'genre-table': etudiantTable,
            'baccalaureat-table': bacTable,
            'mobilite-table': mobiliteTable,
            'inscrits-table': inscritsTable,
            'GD-table': GDTable,
            'Disc-table': DiscTable
        };

        function showTable(tableId) {
            buttons.forEach(btn => btn.classList.remove('active'));
            Object.values(tables).forEach(table => table.table().node().style.display = 'none');

            document.getElementById('bac-info').style.display = 'none';
            tables[tableId].table().node().style.display = '';

            if (tableId === 'baccalaureat-table') {
                document.getElementById('bac-info').style.display = '';
            }
            const selectedButton = document.querySelector(`.btn-group.btn-stat button[data-table="${tableId}"]`);
            selectedButton.classList.add('active');
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const tableId = btn.dataset.table;
                showTable(tableId);
            });
        });

        showTable('genre-table');
    });
    </script>

@endsection