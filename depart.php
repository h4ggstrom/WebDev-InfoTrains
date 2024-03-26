<?php
declare(strict_types=1);
$apiKey = "e9d5c3e8-6cfe-4725-8914-edda6d54d892";
if(isset($_GET['q'])){
  $where = "\"" . $_GET['q'] . "\"";
  $url0 = "https://ressources.data.sncf.com/api/explore/v2.1/catalog/datasets/liste-des-gares/records?where=$where&?limit=1";
  // Initialiser cURL
  $ch1 = curl_init($url0);

  // Définir les options cURL
  curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);

  // Exécuter la requête
  $gareResponse = curl_exec($ch1);

  // Gérer les erreurs cURL
  if (curl_errno($ch1)) {
    echo "Erreur cURL: " . curl_error($ch1);
    die();
  }

  // Décoder le JSON
  $liste_des_gares = json_decode($gareResponse, true);

  $gare = $liste_des_gares["results"][0]["code_uic"];
  $affGare = $liste_des_gares["results"][0]["libelle"]; 
}else{
  $gare = "87271007"; // Gare du Nord
  $affGare = "Paris-Nord";
}
$fromDateTime = date('Ymd') . "T000000" ; // date d'aujourd'hui minuit
$untilDateTime = date("Ymd") . "T235959"; // date d'aujourd'hui 23h59 (59")

//URL de l'API
// pour vérifier sur internet : https://e9d5c3e8-6cfe-4725-8914-edda6d54d892@api.sncf.com/v1/coverage/sncf/stop_areas/stop_area:SNCF:87276535/departures
$url = "https://$apiKey@api.sncf.com/v1/coverage/sncf/stop_areas/stop_area:SNCF:$gare/departures";

// Initialiser cURL
$ch = curl_init($url);

// Définir les options cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Exécuter la requête
$response = curl_exec($ch);

// Gérer les erreurs cURL
if (curl_errno($ch)) {
  echo "Erreur cURL: " . curl_error($ch);
  die();
}

// Décoder le JSON
$data = json_decode($response, true);

/**
 * This function is used to display the informations returned by the API as a HTML table
 * 
 * @param array $data the array returned by the API
 */
function departures(array $data) : void
{
  foreach($data["departures"] as $v) {

    // nom de la gare
    $nomGare = $v["display_informations"]["direction"];

    //heure de départ + conversion (YYYYmmdd T hhmmss --> h + m)
    $departureTime = $v["stop_date_time"]["departure_date_time"];
    $heure = substr($departureTime, 9, 2);
    $minute = substr($departureTime, 11, 2);

    //type de train + ligne
    $trainType = $v["route"]["line"]["commercial_mode"]["name"];
    $line = $v["route"]["line"]["name"];

    echo "<tr><td>$nomGare</td><td>$heure h $minute</td><td>$trainType $line</td></tr>";  
  }
}

// Fermer la session cURL
curl_close($ch);




?>

<?php 
	$title = "UJR Acceuil";
	$h1 = "projet php";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>

<main>

  <form method="get" action="./depart.php">
    <input type="search" placeholder="Entrer un nom de gare" name="q">
    <button type="submit">Rechercher</button>
  </form>

  <h1><?=$affGare;?></h1>
  <table>
    <thead>
      <tr>
        <th>direction</th>
        <th>heure de départ</th>
        <th>ligne</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?php
        departures($data);
      ?>
      </tr>
    </tbody>
  </table>

</main>

<?php

	require "include/footer.inc.php";

?>