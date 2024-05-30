//ajout de la map
const map = L.map("map", {
    maxBounds: [
        [40, -20], // Coin sud-ouest de la France (ajustement légèrement à gauche)
        [52, 20], // Coin nord-est de la France (ajustement légèrement à droite)
    ],
    minZoom: 6,
});

// zoom par defaut
map.setView([46.6031, 1.8883], 6);

// fond de carte au chargement
var numBackground = 0;
var selectedTile = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'ArcGIS'
}).addTo(map);

/*
 * fonction qui soccupe du changement de fond de carte
 */
function changeBackground() {
    // on suprime l'ancien fond de carte avant de le changer
    map.removeLayer(selectedTile);

    numBackground = (numBackground + 1) % 5;

    const tileLayers = [
        'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
        'https://{s}.tile.thunderforest.com/spinal-map/{z}/{x}/{y}.png?apikey=0b17287f3b5d470ba67c163c0c26246e'
    ];

    const attributions = [
        'ArcGIS',
        '<a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        '<a href="http://www.thunderforest.com/">Thunderforest</a>'
    ];

    selectedTile = L.tileLayer(tileLayers[numBackground], {
        attribution: attributions[numBackground]
    }).addTo(map);
}

// ajout de la barre de recherche
L.Control.geocoder().addTo(map);

// ajout du bouton pour changer le fond de carte
L.easyButton(
    "backgroud",
    function (btn, map) {
        changeBackground();
    },
    "changer le fond de carte"
).addTo(map);

// ajout icone au button
var imageElement = document.createElement('img');
imageElement.src = 'img/changeCarte.svg';
imageElement.className = 'imgButton';
document.querySelector('.backgroud').appendChild(imageElement);

// ajout du bouton accueil carte pour recentrer sur la France
L.easyButton(
    "accueil",
    function (btn, map) {
        map.setView([46.6031, 1.8883], 6);

        // rajout de la region seclectioné
        if (region_disable != null) {
            region_disable.addTo(map);
            setStyleRegion(region_disable);
            region_disable = null;
        }
    },
    "Zoom France"
).addTo(map);

// ajout icone au button
var imageElement2 = document.createElement('img');
imageElement2.src = 'img/deZoom.png';
imageElement2.className = 'imgButton';
document.querySelector('.accueil').appendChild(imageElement2);


//écouteur sur l'événement de changement de zoom de la carte
map.on('zoomend', function () {
    var currentZoom = map.getZoom();
    console.log("Niveau de zoom actuel :", currentZoom);



    if (currentZoom <= 18) {
        tab_region.forEach(region => {
            region.remove();
        });
    }

    if (currentZoom <= 8) {
        tab_region.forEach(region => {
            region.addTo(map);
        });

        if (region_disable != null) {
            region_disable.remove();
        }
    }


    if (currentZoom <= 18) {
        tab_coursEau.forEach(coursEau => {
            setWeightCoursEau(coursEau, 7);
        })
    }

    if (currentZoom <= 14) {
        tab_coursEau.forEach(coursEau => {
            setWeightCoursEau(coursEau, 5);
        })
    }

    if (currentZoom <= 9) {
        tab_coursEau.forEach(coursEau => {
            setWeightCoursEau(coursEau, 4);
        })
    }

    if (currentZoom <= 7) {
        tab_coursEau.forEach(coursEau => {
            setWeightCoursEau(coursEau, 3);
        })
    }

    if (currentZoom <= 6) {
        tab_coursEau.forEach(coursEau => {
            setWeightCoursEau(coursEau, 2);
        })
    }

});