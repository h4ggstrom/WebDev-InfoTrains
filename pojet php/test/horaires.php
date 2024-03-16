<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gare = $_POST["gare"];
    $type_train = $_POST["type_train"];
    $date_depart = $_POST["date_depart"];

    // Clé d'authentification SNCF
    $token = "2fed1eb4-473f-44c2-9444-66a5f2b91450";

    // Appel à l'API de la SNCF pour obtenir les horaires de trains
    $url = "https://$token@api.sncf.com/v1/coverage/sncf/places?q=" . urlencode($gare);
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Récupération de l'ID de la gare
    if (!empty($data['places'][0]['id'])) {
        $idGare = $data['places'][0]['id'];

        // Appel à l'API pour obtenir les horaires de trains pour cette gare
        $url_horaires = "https://$token@api.sncf.com/v1/coverage/sncf/stop_areas/{$idGare}/stop_schedules";
        $horaires_response = file_get_contents($url_horaires);
        $horaires_data = json_decode($horaires_response, true);

        // Affichage des informations récupérées
        if (!empty($horaires_data['stop_schedules'])) {
            // Affichage des horaires
            foreach ($horaires_data['stop_schedules'] as $horaire) {
                echo "Train: " . $horaire['display_informations']['headsign'] . "<br>";
                echo "Départ: " . date('H:i', strtotime($horaire['date_times'][0]['departure_date_time'])) . "<br>";
                echo "Arrivée: " . date('H:i', strtotime($horaire['date_times'][0]['arrival_date_time'])) . "<br>";
                echo "<hr>";
            }
        } else {
            echo "Aucun horaire trouvé pour cette gare.";
        }
    } else {
        echo "Gare non trouvée.";
    }
}
?>
