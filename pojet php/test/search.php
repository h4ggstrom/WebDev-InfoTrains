<?php
if(isset($_GET['nomGare'])) {
    $nomGare = $_GET['nomGare'];

    // Appel à l'API GeoNames pour obtenir les informations sur la gare par son nom
    $url = 'http://api.geonames.org/searchJSON?q=' . urlencode($nomGare) . '&maxRows=1&username=yourusername';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    // Vérifie si des résultats ont été retournés
    if(isset($data['geonames']) && count($data['geonames']) > 0) {
        $gare = $data['geonames'][0];

        echo '<h2>Informations sur la gare</h2>';
        echo '<p>Nom: ' . $gare['name'] . '</p>';
        echo '<p>Ville: ' . $gare['adminName1'] . '</p>';
        // Afficher d'autres informations sur la gare si nécessaire
    } else {
        echo '<p>Aucune gare trouvée pour le nom saisi.</p>';
    }
}
?>
