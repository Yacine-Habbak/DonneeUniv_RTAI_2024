<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
      #map {
            height: 420px;
            width: 35%;
            left: 30%;
            top: 180px; 
            position: absolute;
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
        .leaflet-buttons {
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
    <div id="map">
        <div class="container-barre">
            <input type="text" id="barre" class="barre" placeholder="Rechercher ...">
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([46.603354, 1.888334], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        }).addTo(map);

        var coucheAcademie;
        var donneesAcademies;
        var marqueurs = {};
        var nomAcademieSelectionnee = null;

        function styleRegion(feature) {
            return {
                fillColor: '#ff7800',
                weight: 2,
                opacity: 0.5,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        fetch('France.geojson')
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    style: styleRegion,
                    onEachFeature: function(feature, layer) {
                        layer.on('click', function() {
                            map.fitBounds(layer.getBounds());
                        });
                    }
                }).addTo(map);
            })
            .catch(error => console.error('Erreur lors du chargement des données JSON des régions:', error));

        function ajouterMarqueursAcademies(academies) {
            if (coucheAcademie) {
                map.removeLayer(coucheAcademie);
            }

            coucheAcademie = L.geoJSON(academies, {
                pointToLayer: function(feature, latlng) {
                    var marker = L.marker(latlng);
                    marqueurs[feature.properties.libelle] = marker;
                    return marker;
                },
                onEachFeature: function(feature, layer) {
                    var properties = feature.properties || {};
                    var contenuPopup = "<b>Nom:</b> " + (properties.libelle || "Inconnu") + "<br>" +
                                       "<b>Site internet:</b> <a href='" + (properties.site_internet || "#") + "' target='_blank'>" + (properties.site_internet || "Pas de site internet") + "</a><br>" +
                                       "<b>Téléphone:</b> " + (properties.numero_de_telephone || "Pas de numéro de téléphone") + "<br>" +
                                       "<button onclick='voirEtablissements(\"" + properties.uai_identifiant + "\")'>Voir établissements</button>";
                    layer.bindPopup(contenuPopup);
                    layer.on('click', function() {
                        map.setView(layer.getLatLng(), 10);
                    });
                }
            }).addTo(map);
        }

        fetch('academies.geojson')
            .then(response => response.json())
            .then(data => {
                donneesAcademies = data;
                ajouterMarqueursAcademies(data);
            })
            .catch(error => console.error('Erreur lors du chargement des données JSON des académies:', error));

        document.getElementById('barre').addEventListener('input', function() {
            var termeRecherche = this.value.toLowerCase();

            var academiesFiltrees = {
                type: "FeatureCollection",
                features: donneesAcademies.features.filter(function(academie) {
                    return academie.properties.libelle.toLowerCase().includes(termeRecherche);
                })
            };

            if (academiesFiltrees.features.length > 0) {
                var academieCorrespondante = academiesFiltrees.features[0];
                var marqueurCorrespondant = marqueurs[academieCorrespondante.properties.libelle];
                if (marqueurCorrespondant) {
                    map.setView(marqueurCorrespondant.getLatLng(), 10);
                }
            }
        });

        var controleAccueil = L.Control.extend({
            options: {
                position: 'topleft'
            },
            onAdd: function(map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-buttons');
                container.title = "Accueil";
                container.style.width = '34px';
                container.style.height = '34px';
                container.onclick = function(){
                    map.setView([46.603354, 1.888334], 5);
                };
                return container;
            }
        });
        map.addControl(new controleAccueil());

        function voirEtablissements(uai_identifiant) {
            id = uai_identifiant; // stocker le nom de l'académie sélectionnée

            console.log(id); // pour tester
        }

       
    </script>
</body>
</html>
