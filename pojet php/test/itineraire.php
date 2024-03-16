<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itinéraires en Train</title>
</head>
<body>
    <h1>Recherche d'itinéraires en train</h1>
    <!-- Formulaire de recherche d'itinéraires -->
    <form action="itineraire.php" method="get">
        Gare de Départ: <input type="text" name="depart" value="Paris-Gare-de-Lyon" required><br>
        Gare d'Arrivée: <input type="text" name="arrivee" value="Lyon-Part-Dieu" required><br>
        Date et Heure de Départ: <input type="datetime-local" name="date_depart" required><br>
        <input type="submit" value="Rechercher">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['depart'], $_GET['arrivee'], $_GET['date_depart'])) {
        $depart = urlencode($_GET['depart']);
        $arrivee = urlencode($_GET['arrivee']);
        $date_depart = urlencode($_GET['date_depart']);

        // Clé d'authentification SNCF
        $token = "2fed1eb4-473f-44c2-9444-66a5f2b91450";

        // Appel à l'API de la SNCF pour obtenir les itinéraires
        $url = "https://$token@api.sncf.com/v1/coverage/sncf/journeys?from=$depart&to=$arrivee&datetime=$date_depart";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Affichage des résultats
        if (!empty($data['journeys'])) {
            echo "<h2>Résultats de la recherche :</h2>";
            foreach ($data['journeys'] as $journey) {
                echo "<h3>Itinéraire:</h3>";
                foreach ($journey['sections'] as $section) {
                    echo "<p>Départ: {$section['from']['name']}</p>";
                    echo "<p>Arrivée: {$section['to']['name']}</p>";
                    echo "<p>Moyen de Transport: {$section['display_informations']['commercial_mode']}</p>";
                }
                echo "<hr>";
            }
        } else {
            echo "<p>Aucun itinéraire trouvé pour ces paramètres.</p>";
        }
    }
    ?>
</body>
</html>
