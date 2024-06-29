    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carte établissement</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }
            #filtres {
                position: absolute;
                top: 80px;
                left: 250px;
                background-color: rgba(240, 240, 240, 0.9);
                padding: 10px;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(59, 129, 208, 0.2);
                z-index: 1000;
                display: flex;
                flex-wrap: wrap;
                gap: 40px;
            }
            .barre {
                flex: 1;
                max-width: 300px;
                padding: 5px;
                border-radius: 8px;
                border: 1px solid #ccc;
                box-shadow: 0 2px 6px rgba(59, 129, 208, 0.2);
            }
            .filter-options {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            }
            .filter-options label {
                margin-right: 10px;
            }
            .boutons-leaflet {
                background-color: white;
                background-image: url('images/home.png');
                background-size: 30px 30px;
                background-repeat: no-repeat;
                background-position: center;
                border: 2px solid rgba(0,0,0,0.2);
                border-radius: 3px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                cursor: pointer;
            }
            #carte {
                position: absolute;
                border-radius: 20px;
                height: 65%;
                width: 80%;
                left: 10%;
                top: 20%;
                z-index: 1;
            }
            
        </style>
    </head>
    <body>
        <div id="filtres">
            <input type="text" id="barre" class="barre" placeholder="Rechercher ...">
            <div class="filter-options">
                <label><input type="checkbox" class="filter-type" value="École"> École</label>
                <label><input type="checkbox" class="filter-type" value="Université"> Université</label>
                <label><input type="checkbox" class="filter-type" value="Autre établissement"> Autre établissement</label>
                <label><input type="checkbox" class="filter-type" value="Grand établissement"> Grand établissement</label>
                <label><input type="checkbox" class="filter-secteur" value="privé"> Privé</label>
                <label><input type="checkbox" class="filter-secteur" value="public"> Public</label>
            </div>
        </div>

        <div id="carte"></div>


        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            var carte = L.map('carte').setView([46.603354, 1.888334], 5);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(carte);

            var iconeGenerale = L.icon({
                iconUrl: 'images/icon_acad.png',
                iconSize: [25, 25],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var marqueurs = [];

            @foreach($coordonnes as $coord)
                var popupContent = `<b>{{ $coord->Etablissement }}</b><br>Type: {{ $coord->Type }}<br>Secteur: {{ $coord->Secteur }}`;
                var marqueur = L.marker([{{ $coord->lat }}, {{ $coord->lon }}], { icon: iconeGenerale }).bindPopup(popupContent);
                marqueurs.push({ 
                    nom: "{{ $coord->Etablissement }}".toLowerCase(), 
                    marqueur: marqueur,
                    type: "{{ $coord->Type }}", 
                    secteur: "{{ $coord->Secteur }}" 
                });
            @endforeach

            marqueurs.forEach(function(item) {
                item.marqueur.addTo(carte);
            });

            document.getElementById('barre').addEventListener('input', function() {
                var termeRecherche = this.value.toLowerCase();
                var marqueurTrouve = null;
                for (var i = 0; i < marqueurs.length; i++) {
                    if (marqueurs[i].nom.includes(termeRecherche)) {
                        marqueurTrouve = marqueurs[i].marqueur;
                        break;
                    }
                }
                if (marqueurTrouve) {
                    carte.setView(marqueurTrouve.getLatLng(), 10);
                    marqueurTrouve.openPopup();
                }
            });

            document.querySelectorAll('.filter-type').forEach(function(checkbox) {
                checkbox.addEventListener('change', filtrerMarqueurs);
            });

            document.querySelectorAll('.filter-secteur').forEach(function(checkbox) {
                checkbox.addEventListener('change', filtrerMarqueurs);
            });

            function filtrerMarqueurs() {
                var typesFiltre = Array.from(document.querySelectorAll('.filter-type:checked')).map(function(checkbox) {
                    return checkbox.value;
                });

                var secteursFiltre = Array.from(document.querySelectorAll('.filter-secteur:checked')).map(function(checkbox) {
                    return checkbox.value;
                });

                marqueurs.forEach(function(item) {
                    carte.removeLayer(item.marqueur);
                    if ((typesFiltre.length === 0 || typesFiltre.includes(item.type)) && 
                        (secteursFiltre.length === 0 || secteursFiltre.includes(item.secteur))) {
                        item.marqueur.addTo(carte);
                    }
                });
            }
            var controleAccueil = L.Control.extend({
            options: {
                position: 'topleft'
            },
            onAdd: function(carte) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control boutons-leaflet');
                container.title = "Accueil";
                container.style.width = '34px';
                container.style.height = '34px';
                container.onclick = function(){
                    carte.setView([46.603354, 1.888334], 5);
                };
                return container;
            }
        });
        carte.addControl(new controleAccueil());

            
        </script>
    </body>
    </html>
