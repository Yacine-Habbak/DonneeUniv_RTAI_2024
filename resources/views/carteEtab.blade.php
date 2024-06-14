<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte établissemnt</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #carte {
            position: absolute;
            border-radius: 40px;
            height: 65%;
            width: 35%;
            left: 35%;
            top: 20%;
        }
        .container-barre {
            position: absolute;
            top: 10px;
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 1000;
        }
        .barre {
            width: 300px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
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
    </style>
</head>
<body>
    <div id="carte">
        <div class="container-barre">
            <input type="text" id="barre" class="barre" placeholder="Rechercher ...">
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var carte = L.map('carte').setView([46.603354, 1.888334], 5);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(carte);

        var marqueurs = {};

        
        @foreach($coordonnes as $coord)
            var marqueur = L.marker([{{ $coord->lat }}, {{ $coord->lon }}]).addTo(carte)
                .bindPopup('<b>{{ $coord->Etablissement }}</b>');
            marqueurs["{{ $coord->Etablissement }}".toLowerCase()] = marqueur;
        @endforeach

        document.getElementById('barre').addEventListener('input', function() {
            var termeRecherche = this.value.toLowerCase();
            var marqueurTrouve = null;
            for (var nom in marqueurs) {
                if (nom.includes(termeRecherche)) {
                    marqueurTrouve = marqueurs[nom];
                    break;
                }
            }
            if (marqueurTrouve) {
                carte.setView(marqueurTrouve.getLatLng(), 10);
                marqueurTrouve.openPopup();
            }
        });

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
