@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Liste des disciplines</h1>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-3 d-flex">
                    <input type="text" id="filtreEtab" class="filtreEtab filtre" placeholder="Rechercher un établissement">
                    <input type="text" id="filtreAcad" class="filtreAcad filtre" placeholder="Rechercher une académie">
                    <input type="text" id="filtreDisc" class="filtreDisc filtre" placeholder="Rechercher une discipline">
                    <div class="filtre-case">
                        <label for="filtreTypeEtab">Type d'établissement :</label><br>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input class="form-check-input filtreTypeEtab" type="checkbox" name="typeEtab" id="Grand établissement" value="Grand établissement">
                                    <label class="form-check-label" for="Grand établissement">Grand établissement</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filtreTypeEtab" type="checkbox" name="typeEtab" id="Autre établissement" value="Autre établissement">
                                    <label class="form-check-label" for="Autre établissement">Autre établissement</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input filtreTypeEtab" type="checkbox" name="typeEtab" id="Université" value="Université">
                                    <label class="form-check-label" for="Université">Université</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive-disc">
                    <table id="disciplineTable" class="table text-center">
                        <thead class="text-white">
                            <tr>
                                <th>Rang</th>
                                <th style="cursor: pointer;">Etablissement</th>
                                <th style="cursor: pointer;">Type</th>
                                <th>Secteur</th>
                                <th style="cursor: pointer;">Académie</th>
                                <th>Discipline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($disciplines as $discipline)
                                @if ($discipline->etablissement)
                                    <tr>
                                        <td>{{ $discipline->id }}</td>
                                        <td><a href="{{ route('etablissements.show', $discipline->etablissement->id) }}" class="text-decoration-none" style="color: inherit;">{{ $discipline->etablissement->Etablissement }}</td>
                                        <td>{{ $discipline->etablissement->Type }}</td>
                                        <td>{{ $discipline->etablissement->Secteur }}</td>
                                        <td>{{ $discipline->etablissement->Academie }}</td>
                                        <td class="text-start">
                                            @php
                                                $Liste_Discipline = explode('//', $discipline->Discipline);
                                            @endphp
                                            @foreach ($Liste_Discipline as $index => $element)
                                                @if($index > 0)
                                                    <br>
                                                @endif
                                                {{ $element }}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
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
                    { orderable: false, targets: [0, 5] }
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

            // Filtrage
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var filtreDisc = $('#filtreDisc').val().toLowerCase();
                    var filtreEtab = $('#filtreEtab').val().toLowerCase();
                    var filtreAcad = $('#filtreAcad').val().toLowerCase();
                    var filtreTypeEtab = $('.filtreTypeEtab:checked').map(function() {
                        return $(this).val().toLowerCase();
                    }).get();

                    var etablissement = data[1].toLowerCase();
                    var type = data[2].toLowerCase();
                    var acad = data[4].toLowerCase();
                    var discipline = data[5].toLowerCase();

                    var matchesDiscipline = filtreDisc === '' || discipline.includes(filtreDisc);
                    var matchesEtablissement = filtreEtab === '' || etablissement.includes(filtreEtab);
                    var matchesAcad = filtreAcad === '' || acad.includes(filtreAcad);
                    var matchesType = filtreTypeEtab.length === 0 || filtreTypeEtab.includes(type);

                    return matchesDiscipline && matchesEtablissement && matchesAcad && matchesType;
                }
            );

            $('#filtreDisc, #filtreEtab, #filtreAcad').on('input', function() {
                table.draw();
            });
            $('.filtreTypeEtab').on('change', function() {
                table.draw();
            });
        });
</script>


@endsection