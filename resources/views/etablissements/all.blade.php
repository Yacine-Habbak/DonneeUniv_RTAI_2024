@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Principaux établissements de l'enseignement supérieur</h1>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="mb-3 d-flex">
                    <input type="text" id="filtreTitle" class="filtreTitle filtre" placeholder="Rechercher un établissement">
                    <input type="text" id="filtreCommune" class="filtreCommune filtre" placeholder="Rechercher une commune">
                    <div class="filtre-case">
                        <label for="filtreType">Type d'établissement :</label><br>
                        <div class="form-check">
                            <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeUniversite" value="Université">
                            <label class="form-check-label" for="typeUniversite">Université</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeEcole" value="École">
                            <label class="form-check-label" for="typeEcole">École</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeGrand" value="Grand établissement">
                            <label class="form-check-label" for="typeGrand">Grand établissement</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filtreType" type="checkbox" name="typeEtablissement" id="typeAutre" value="Autre établissement">
                            <label class="form-check-label" for="typeAutre">Autre établissement</label>
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
                <div class="btn-group btn-univ" role="group">
                    <button type="button" class="btn btn-outline-primary">Vue Carte</button>
                    <button type="button" class="btn btn-outline-primary">Vue Graphique</button>
                </div>

                <div class="table-responsive-univ">
                    <table id="etablissementsTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Établissement</th>
                                <th style="cursor: pointer;">Catégorie</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Secteur</th>
                                <th style="cursor: pointer;">Étudiants inscrits <sup>1</sup></th>
                                <th style="cursor: pointer;">Effectif Personnels <sup>2</sup></th>
                                <th style="cursor: pointer;">Effectif enseignants</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etablissements as $etablissement)
                                <tr>
                                    <td>{{ $etablissement->id }}</td>
                                    <td>{{ $etablissement->Etablissement }}</td>
                                    <td>{{ $etablissement->Type }}</td>
                                    <td>{{ $etablissement->Commune }}</td>
                                    <td>{{ $etablissement->Secteur }}</td>
                                    <td>{{ $etablissement->Etudiants_inscrits_2022 ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Personnels_non_enseignant == 0 ? 'nd' : $etablissement->Personnels_non_enseignant ?? 'nd' }}</td>
                                    <td>{{ $etablissement->Enseignants == 0 ? 'nd' : $etablissement->Enseignants ?? 'nd' }}</td>
                                    <td><a href="#"><img src="{{ asset('images/fiche.png') }}" class="icone-img" alt="Fiche de l'établissement"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <p><sup>1</sup> Étudiants inscrits sur l'année 2022-2023</p>
                    </div>
                    <div class="col-md-2">
                        <p><sup>2</sup> Personnels hors enseignants</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
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
                    }, targets: [5, 6, 7]
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

            // Filtrage
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var filtreTitle = $('#filtreTitle').val().toLowerCase();
                    var filtreCommune = $('#filtreCommune').val().toLowerCase();
                    var filtreTypes = $('.filtreType:checked').map(function() {
                        return $(this).val().toLowerCase();
                    }).get();
                    var filtreSecteurs = $('.filtreSecteur:checked').map(function() {
                        return $(this).val().toLowerCase();
                    }).get();

                    var etablissement = data[1].toLowerCase();
                    var commune = data[3].toLowerCase();
                    var type = data[2].toLowerCase();
                    var secteur = data[4].toLowerCase();

                    var matchesTitle = filtreTitle === '' || etablissement.includes(filtreTitle);
                    var matchesCommune = filtreCommune === '' || commune.includes(filtreCommune);
                    var matchesType = filtreTypes.length === 0 || filtreTypes.includes(type);
                    var matchesSecteur = filtreSecteurs.length === 0 || filtreSecteurs.includes(secteur);

                    return matchesTitle && matchesCommune && matchesType && matchesSecteur;
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