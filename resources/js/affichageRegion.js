/* --------------- AJOUT REGION --------------- */

function parametrageRegion(region) {

    setStyleRegion(region);

    // evenement au click sur une region
    region.on("click", function (e) {
        zoom_region(e);
        region.remove();

        if (region_disable != null) {
            region_disable.addTo(map);
            setStyleRegion(region_disable);
        }

        region_disable = region;
    });

    // evenement au survol sur une region
    region.on("mouseover", function (e) {
        region.setStyle({
            fillColor: "#FFFF00",
            weight: 2,
            fillOpacity: 0.2
        });
    });

    // evenement au dé-survol sur une region
    region.on("mouseout", function (e) {
        setStyleRegion(region);
    });
}

//coloration toutes les régions
function setStyleRegion(region) {
    region.setStyle({
        fillColor: "rgba(250,0,0,0)",
        color: "rgba(0,0,0,0.8)", // couleur de bordure
        weight: 1,
        fillOpacity: 0.1
    });
}

// pour zoomer lorsque on sélectionne une région
function zoom_region(e) {
    map.fitBounds(e.target.getBounds());
}

function drawRegions() {
    var tab_region = [];

    fetch("resources/France.geojson")
        .then((response) => response.json())
        .then((fileContent) => {
            //console.log(fileContent);

            (fileContent.features).forEach(regionGeojson => {

                // ajoute la region sur la carte
                var region = L.geoJson(regionGeojson).addTo(map);

                // parametrage de l'affichage de la region
                parametrageRegion(region);
                
                tab_region.push(region);
            });
        })
        .catch((error) =>
            console.error("Erreur du chargement du fichier GeoJSON :", error)
        );
    return tab_region;
}