<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
</head>
<body>
    <h1>Résultats de recherche</h1>
    <?php
    if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['datetime'])) {
        $from = $_GET['from'];
        $to = $_GET['to'];
        $datetime = urlencode($_GET['datetime']);

        $api_url = "https://api.sncf.com/v1/coverage/sncf/journeys?from=$from&to=$to&datetime=$datetime";

        $api_key = 'baf404f6-03bc-4613-9c90-ec1e968c93b9'; // Remplacez par votre propre clé API SNCF

        $options = [
            'http' => [
                'header' => "Authorization: apikey $api_key\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($api_url, false, $context);

        if($response) {
            $data = json_decode($response, true);
            
            // Vérifier si des itinéraires sont disponibles
            if(isset($data['journeys']) && count($data['journeys']) > 0) {
                echo "<h2>Itinéraires disponibles :</h2>";
                echo "<ul>";
                foreach($data['journeys'] as $journey) {
                    echo "<li>";
                    echo "Départ : " . $journey['departure_date_time'] . "<br>";
                    echo "Arrivée : " . $journey['arrival_date_time'] . "<br>";
                    echo "Durée : " . $journey['duration'] . "<br>";
                    // Vous pouvez ajouter d'autres détails comme les correspondances, les prix, etc.
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "Aucun itinéraire disponible pour cette recherche.";
            }
        } else {
            echo "Une erreur est survenue lors de la récupération des itinéraires.";
        }
    } else {
        echo "Veuillez spécifier une ville de départ, une ville d'arrivée et une date.";
    }
    ?>
</body>
</html>
