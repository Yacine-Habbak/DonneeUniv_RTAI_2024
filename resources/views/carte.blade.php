<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>carte</title>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">

<body>
    <div id="map">

    <!--------------- Récupération de la carte leaflet--------------->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--------------- Barre de recherche--------------->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!--------------- easybutton plugin pour mon bouton acceuil--------------->
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>


    <!--------------- Script qui gere la carte --------------->
    <script src="js/carte.js"></script>

    <script src="js/affichageRegion.js"></script>

    <script>
        /* --------------- AJOUT REGION --------------- */

        var region_disable = null;
        // recup et trace les region sur la carte
        var tab_region = drawRegions();;

    </script>
</body>

</html>