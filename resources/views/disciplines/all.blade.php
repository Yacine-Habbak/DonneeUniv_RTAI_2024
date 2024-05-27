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
        <h1>Liste des disciplines</h1>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-3 d-flex">
                    <input type="text" id="filtreDiscipline" class="filtreDiscipline filtre" placeholder="Rechercher une discipline">
                    <input type="text" id="filtreEtablissement" class="filtreEtablissement filtre" placeholder="Rechercher un établissement">
                    <input type="text" id="filtreVille" class="filtreVille filtre" placeholder="Rechercher une ville">
                    <div class="filtre-case">
                        <label for="filtreDiplome">Type de diplome :</label><br>
                        <div class="form-check">
                            <input class="form-check-input filtreDiplome" type="checkbox" name="typeDiplome" id="Licence professionnelle" value="Licence professionnelle">
                            <label class="form-check-label" for="Licence professionnelle">Licence professionnelle</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filtreDiplome" type="checkbox" name="typeDiplome" id="Master LMD" value="Master LMD">
                            <label class="form-check-label" for="Master LMD">Master LMD</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filtreDiplome" type="checkbox" name="typeDiplome" id="Master MEEF" value="Master MEEF">
                            <label class="form-check-label" for="Master MEEF">Master MEEF</label>
                        </div>
                    </div>
                </div>
                <div class="btn-group mb-3" role="group">
                    <button type="button" class="btn btn-outline-primary">Vue Graphique</button>
                </div>

                <div>
                    <table id="disciplineTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Discipline</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Commune</th>
                                <th style="cursor: pointer;">Type de diplome</th>
                                <th style="cursor: pointer;">Nom du diplome</th>
                                <th style="cursor: pointer;">Date d'insertion</th>
                                <th style="cursor: pointer;">TR</th>
                                <th style="cursor: pointer;">TE</th>
                                <th style="cursor: pointer;">TI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($disciplines as $discipline)
                                <tr>
                                    <td>{{ $discipline->id }}</td>
                                    <td>{{ $discipline->Discipline }}</td>
                                    <td>{{ $discipline->etablissement->Etablissement }}</td>
                                    <td>{{ $discipline->etablissement->Commune }}</td>
                                    <td>{{ $discipline->Type_diplome }}</td>
                                    <td>{{ $discipline->Nom_diplome }}</td>
                                    <td>{{ $discipline->Date_insertion }}</td>
                                    <td>{{ $discipline->Taux_reussite ? $discipline->Taux_reussite . ' %' : 'nd' }}</td>
                                    <td>-</td>
                                    <td>{{ $discipline->Taux_insertion }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#disciplineTable').DataTable({
                paging: false,
                ordering: true,
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: 0 }
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
                    var filtreDiscipline = $('#filtreDiscipline').val().toLowerCase();
                    var filtreEtablissement = $('#filtreEtablissement').val().toLowerCase();
                    var filtreVille = $('#filtreVille').val().toLowerCase();
                    var filtreDiplome = $('.filtreDiplome:checked').map(function() {
                        return $(this).val().toLowerCase();
                    }).get();

                    var discipline = data[1].toLowerCase();
                    var etablissement = data[2].toLowerCase();
                    var ville = data[3].toLowerCase();
                    var diplome = data[4].toLowerCase();

                    var matchesDiscipline = filtreDiscipline === '' || discipline.includes(filtreDiscipline);
                    var matchesEtablissement = filtreEtablissement === '' || etablissement.includes(filtreEtablissement);
                    var matchesVille = filtreVille === '' || ville.includes(filtreVille);
                    var matchesDiplome = filtreDiplome.length === 0 || filtreDiplome.includes(filtreDiplome);

                    return matchesDiscipline && matchesEtablissement && matchesVille && matchesDiplome;
                }
            );

            $('#filtreDiscipline, #filtreEtablissement, #filtreVille').on('input', function() {
                table.draw();
            });
            $('.filtreDiplome').on('change', function() {
                table.draw();
            });
        });
    </script>


@endsection