
<?php 
	$title = "UJR Acceuil";
	$h1 = "projet php";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>

    <form method="GET">
        <label for="search">Rechercher :</label>
        <input type="text" id="search" name="search">
        <input type="submit" value="Rechercher">
    </form>

    <?php

    function afficherCarte($latitude, $longitude, $zoom = 10, $largeur = 600, $hauteur = 400) {
        // Création de l'URL pour afficher la carte OpenStreetMap avec un marqueur à la position spécifiée
        $url = "https://www.openstreetmap.org/export/embed.html?bbox=" . ($longitude-0.01) . "," . ($latitude-0.01) . "," . ($longitude+0.01) . "," . ($latitude+0.01) . "&layer=mapnik";

        // Ajout des marqueurs à l'URL
        $url .= "&amp;marker=$latitude,$longitude";

        // Affichage de la carte dans un iframe
        echo "<iframe width=\"$largeur\" height=\"$hauteur\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"$url\"></iframe>";
    }
    // Traitement du formulaire de recherche de gares
    if(isset($_GET['search'])) {
        $searchTerm = urlencode($_GET['search']);
        $base_path = "https://ressources.data.sncf.com/api/explore/v2.1";
        $dataset_path = "/catalog/datasets/gares-de-voyageurs/records";
        $horaires_dataset_path = "/catalog/datasets/horaires-des-gares1/records";

        $url = $base_path . $dataset_path . "?limit=100&where=codeinsee%20like%20%22$searchTerm%22%20OR%20nom%20like%20%22$searchTerm%22";

        // echo "URL de requête : " . $url;

        // Appel à l'API
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Vérifier si les données ont été récupérées avec succès et si elles existent
        if(isset($data['results']) && count($data['results']) > 0) {
            // Affichage des résultats
            echo "<h1>Résultats de la recherche :</h1>";
            foreach($data['results'] as $result) {
                echo "<h2>Informations sur la gare :</h2>";
                foreach($result as $key => $value) {
                    if(is_array($value)) {
                        // Si la valeur est un tableau (par exemple, position géographique)
                        echo "<p>$key :</p><ul>";
                        foreach($value as $subKey => $subValue) {
                            echo "<li>$subKey : $subValue</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>$key : $value</p>";
                    }
                }
                $lon = $result['position_geographique']['lon'];
                $lat = $result['position_geographique']['lat'];
                afficherCarte($lat, $lon);


                // Récupérer le nom normal de la gare pour la recherche d'horaires
                $nom_gare = urlencode($result['nom']);

                // Construire l'URL de requête pour les horaires de la gare
                $url_horaires = $base_path . $horaires_dataset_path . "?where=nom_normal%20like%20%22$nom_gare%22";

                // Appel à l'API pour les horaires de la gare
                $response_horaires = file_get_contents($url_horaires);
                $data_horaires = json_decode($response_horaires, true);

                // Vérifier si les horaires de la gare ont été récupérés avec succès et si elles existent
                if(isset($data_horaires['results']) && count($data_horaires['results']) > 0) {
                    // Affichage des horaires
                    echo "<h2>Horaires de la gare :</h2>";
                    // echo "<p>URL pour la requête des horaires : $url_horaires</p>";
                    echo "<table>";
                    echo "<thead>
                        <tr>
                            <th>jour</th>
                            <th>horaires normaux</th>
                            <th>horaires en jour férié</th>
                        </tr>
                    </thead><tbody>";
                    foreach($data_horaires['results'] as $horaire) {
                        echo "<tr><td>" . $horaire['jour'] . "</td>";
                        echo "<td>".$horaire['horaire_normal']."</td>";
                        if(isset($horaire['horaire_ferie']) && ($horaire['horaire_ferie'] !== null)) {
                            echo "<td>" . $horaire['horaire_ferie'] . "</td></tr>";
                        }
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>Aucun horaire trouvé pour cette gare.</p>";
                }
            }
        } else {
            echo "<p>Aucune donnée trouvée.</p>";
        }
    }
    ?>
</main>

<?php

	require "include/footer.inc.php";

?>