<?php

function afficherCarteAvecItineraire($positionDepart, $positionArrivee, $zoom = 10, $largeur = 600, $hauteur = 400) {
    // Convertir les coordonnées en chaînes de latitude et de longitude
    $depart = implode(',', $positionDepart);
    $arrivee = implode(',', $positionArrivee);

    // Création de l'URL pour demander l'itinéraire à OSRM
    $url = "http://router.project-osrm.org/route/v1/driving/$depart;$arrivee?geometries=geojson";

    // Récupération des données de l'itinéraire
    $itineraire_json = file_get_contents($url);

    // Vérifier si la requête a réussi
    if ($itineraire_json !== false) {
        $itineraire_data = json_decode($itineraire_json, true);

        // Vérifier si l'itinéraire a été trouvé avec succès
        if ($itineraire_data && isset($itineraire_data['routes'][0]['geometry'])) {
            // Récupérer les coordonnées de l'itinéraire
            $geometry = $itineraire_data['routes'][0]['geometry'];

            // Créer une URL pour afficher la carte OpenStreetMap avec l'itinéraire
            $url_carte = "https://www.openstreetmap.org/export/embed.html?bbox=" . ($positionDepart[1]-0.01) . "," . ($positionDepart[0]-0.01) . "," . ($positionDepart[1]+0.01) . "," . ($positionDepart[0]+0.01) . "&layer=mapnik";

            // Ajout des coordonnées de l'itinéraire à l'URL de la carte
            $url_carte .= "&addlayer=https://api.openrouteservice.org/v2/directions/driving-car/geojson?route=geometry(" . urlencode(json_encode($geometry)) . ")&addlayername=Itinéraire";

            // Affichage de la carte dans un iframe
            echo "<iframe width=\"$largeur\" height=\"$hauteur\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"$url_carte\"></iframe>";
        } else {
            echo "Impossible de trouver un itinéraire.";
        }
    } else {
        echo "Erreur lors de la récupération des données de l'itinéraire.";
    }
}

// Exemple d'utilisation
$positionDepart = array(48.8566, 2.3522); // Exemple de position de départ (Paris)
$positionArrivee = array(48.8405, 2.2654); // Exemple de position d'arrivée (Gare de Paris)
afficherCarteAvecItineraire($positionDepart, $positionArrivee);

?>
