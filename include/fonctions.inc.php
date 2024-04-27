<?php 

/**
 * Fonction pour obtenir l'adresse IP du visiteur.
 * 
 * @return string Adresse IP du visiteur.
 */
function getVisitorIP(): string 
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/**
 * Fonction pour récupérer et afficher l'image ou la vidéo de l'API de la NASA avec le texte du jour.
 * 
 * @return string Contenu HTML de l'image ou de la vidéo.
 */
function fetchAPOD(): string 
{
    $apiKey = 'ViJkzG7JONaWOcpDw4QYjGZ8pbNCPbGIzhQ5ypSr';
    $currentDate = date('Y-m-d');
    $apodApiUrl = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}&date={$currentDate}";

    try {
        $apodResponse = file_get_contents($apodApiUrl);
        $apodData = json_decode($apodResponse);

        if ($apodData->media_type === 'image') {
            // Si c'est une image, l'afficher
            return "<figure>
                        <img src=\"{$apodData->url}\" alt=\"APOD\"/>
                        <figcaption>{$apodData->title} - {$apodData->date} ({$apodData->explanation})</figcaption>
                    </figure>";
        } elseif ($apodData->media_type === 'video') {
            // Si c'est une vidéo, utiliser la balise vidéo HTML5
            return "<video width=\"100%\" height=\"auto\" controls><source src=\"{$apodData->url}\" type=\"video/mp4\"></video>";
        } else {
            return 'Type de média non pris en charge.';
        }
    } catch (Exception $e) {
        return '<p>Erreur lors du chargement des données APOD: </p>' . $e->getMessage();
    }
}

/**
 * Fonction pour récupérer et afficher les informations de localisation avec ipinfo.io.
 * 
 * @return string Contenu HTML des informations de localisation.
 */
function fetchIpInfoLocation(): string 
{
    $visitorIP = getVisitorIP();
    $ipinfoApiUrl = "https://ipinfo.io/{$visitorIP}/json";

    try {
        $ipinfoResponse = file_get_contents($ipinfoApiUrl);
        $ipinfoData = json_decode($ipinfoResponse);

        $city = $ipinfoData->city;
        $region = $ipinfoData->region;
        $country = $ipinfoData->country;
        $postalCode = $ipinfoData->postal;
        $latitude = $ipinfoData->loc ? explode(',', $ipinfoData->loc)[0] : '';
        $longitude = $ipinfoData->loc ? explode(',', $ipinfoData->loc)[1] : '';

        $locationInfo = "<p>Ville: {$city}</p>";
        $locationInfo .= "<p>Région: {$region}</p>";
        $locationInfo .= "<p>Pays: {$country}</p>";
        $locationInfo .= "<p>Code Postal: {$postalCode}</p>";
        $locationInfo .= "<p>Coordonnées géographiques : Latitude {$latitude}, Longitude {$longitude}</p>";

        return $locationInfo;
    } catch (Exception $e) {
        return '<p>Erreur lors du chargement de la localisation par adresse IP: </p>' . $e->getMessage();
    }
}

/**
 * Fonction pour récupérer et afficher les informations de localisation avec GeoPlugin (JSON).
 * 
 * @return string Contenu HTML des informations de localisation.
 */
function fetchGeoPluginLocationJson(): string 
{
    $visitorIP = getVisitorIP();
    $geoPluginJsonUrl = "http://www.geoplugin.net/json.gp?ip={$visitorIP}";

    try {
        $geoPluginJsonResponse = file_get_contents($geoPluginJsonUrl);
        $geoPluginJsonData = json_decode($geoPluginJsonResponse, true);

        $city = $geoPluginJsonData['geoplugin_city'];
        $region = $geoPluginJsonData['geoplugin_region'];
        $country = $geoPluginJsonData['geoplugin_countryName'];

        $locationInfo = "<p>Ville: {$city}</p>";
        $locationInfo .= "<p>Région: {$region}</p>";
        $locationInfo .= "<p>Pays: {$country}</p>";

        return $locationInfo;
    } catch (Exception $e) {
        return '<p>Erreur lors du chargement de la localisation par adresse IP (JSON): </p>' . $e->getMessage();
    }
}

/**
 * Fonction pour récupérer et afficher les informations de localisation avec GeoPlugin (XML).
 * 
 * @return string Contenu HTML des informations de localisation.
 */
function fetchGeoPluginLocationXml(): string 
{
    $visitorIP = getVisitorIP();
    $geoPluginXmlUrl = "http://www.geoplugin.net/xml.gp?ip={$visitorIP}";

    try {
        $geoPluginXmlResponse = file_get_contents($geoPluginXmlUrl);
        $geoPluginXml = simplexml_load_string($geoPluginXmlResponse);

        $city = $geoPluginXml->geoplugin_city;
        $region = $geoPluginXml->geoplugin_region;
        $country = $geoPluginXml->geoplugin_countryName;

        $locationInfo = "<p>Ville: {$city}</p>";
        $locationInfo .= "<p>Région: {$region}</p>";
        $locationInfo .= "<p>Pays: {$country}</p>";

        return $locationInfo;
    } catch (Exception $e) {
        return '<p>Erreur lors du chargement de la localisation par adresse IP (XML): </p>' . $e->getMessage();
    }
}

/**
 * Fonction pour récupérer le code HTML pour afficher les informations de localisation avec GeoPlugin (CSV).
 * 
 * @return string Le code HTML pour afficher les informations de localisation.
 */
function getGeoPluginLocationCsvCode(): string 
{
    $visitorIP = getVisitorIP();
    $geoPluginCsvUrl = "http://www.geoplugin.net/csv.gp?ip={$visitorIP}";
    $locationInfo = '';
    $city = 'Non disponible';
    $region = 'Non disponible';
    $country = 'Non disponible';

    try {
        $geoPluginCsvResponse = file_get_contents($geoPluginCsvUrl);
        $geoPluginCsvData = str_getcsv($geoPluginCsvResponse, "\n"); // Explode lines
        foreach ($geoPluginCsvData as $line) {
            $lineData = str_getcsv($line);
            if (count($lineData) >= 2) {
                if ($lineData[0] === 'geoplugin_city') {
                    $city = $lineData[1];
                } elseif ($lineData[0] === 'geoplugin_region') {
                    $region = $lineData[1];
                } elseif ($lineData[0] === 'geoplugin_countryName') {
                    $country = $lineData[1];
                }
            }
        }

        // Construction du code HTML pour afficher les informations de localisation
        $locationInfo .= "<p>Ville: {$city}</p>";
        $locationInfo .= "<p>Région: {$region}</p>";
        $locationInfo .= "<p>Pays: {$country}</p>";
    } catch (Exception $e) {
        // En cas d'erreur, affichage d'un message d'erreur
        $locationInfo .= '<p>Erreur lors du chargement de la localisation par adresse IP (CSV): </p>' . $e->getMessage();
    }

    // Retourner le code HTML pour afficher les informations de localisation
    return $locationInfo;
}

/**
 * Gère le choix du thème (mode jour/nuit) sur le site web.
 *
 * Cette fonction utilise des cookies pour mémoriser la préférence de l'utilisateur
 * et inclut également le fichier CSS correspondant au thème sélectionné.
 *
 * @return string Le mode actuel sélectionné ('jour' ou 'nuit').
 */
function gestionTheme(string $src): string 
{
    // Vérification si le mode a été choisi
    if(isset($_GET['mode'])) {
        // Mode nuit choisi
        if($_GET['mode'] === 'nuit') {
            // Définition du cookie pour le mode nuit
            setcookie('mode', 'nuit', time() + (86400 * 30));
            return 'nuit';
        }
        // Mode jour choisi
        else if($_GET['mode'] === 'jour') {
            // Définition du cookie pour le mode jour
            setcookie('mode', 'jour', time() + (86400 * 30));
            return 'jour'; 
        }
    }

    // Vérification si le cookie existe
    if(isset($_COOKIE['mode'])) {
        // Vérification de la valeur du cookie pour déterminer le mode actuel
        return ($_COOKIE['mode'] === 'nuit') ? 'nuit' : 'jour';
    }

    // Mode par défaut : jour
    return 'jour';
}

/**
 * cette fonction sert à afficher les départs d'une certaine gare, à partir du flux JSON renvoyé par l'appel à l'API
 * 
 * @param array $data le flux JSON
 * @return string $html le tableau au format HTML, contenant les prochains départs
 */
function departures(array $data) : string
{
    if(count($data) === 0){return "<p>informations non disponibles</p>";}
    //if(isset($data) && count($data['results']) > 0)
    //{
        $html =  
        "<table>
        <thead>
            <tr>
            <th>direction</th>
            <th>heure de départ</th>
            <th>ligne</th>
            </tr>
        </thead>
        <tbody>";
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

            $html .=  
            "<tr>
            <td>$nomGare</td>
            <td>$heure h $minute</td>
            <td>$trainType $line</td>
            </tr>";
        }
        $html .=
        "</tbody>
        </table>";
        setcookie("lastDeparture", $html, time() + (86400 * 30));
        updateStats(lastDepartureName());
    //}
    //else{
    //    $html = "<p> la gare n'a pas été trouvée<p>";
    //}
    
    return $html;
  
}

/**
 * Cette fonction sert à faire l'appel à l'API SNCF afin de récupérer tous les départs d'une gare précise.
 * 
 * Elle fait en réalité 2 appels : le premier sert à trouver le nom de gare ressemblant le plus au nom entré par l'utilisateur (aka le premier résultat renvoyé par l'API).
 * Le deuxième s'occupe de récupérer les informations de départ, à partir du nom de gare renvoyé par le premier appel.
 *

 * @return array retourne un "array" resultat du flux JSON décodé.
 */
function departuresAPIRequest() : array
{
    if(isset($_GET['q']))
    {
        $apiKey = "e9d5c3e8-6cfe-4725-8914-edda6d54d892";
        //$url0 = "https://ressources.data.sncf.com/api/explore/v2.1/catalog/datasets/liste-des-gares/records?where=$where&?limit=1";

        //construction de l'URL
        $searchTerm =  "\"" .rawurlencode($_GET['q']). "\"";
        $base_path = "https://ressources.data.sncf.com/api/explore/v2.1/";
        $dataset_path = "catalog/datasets/liste-des-gares/records";
        $url0 = $base_path . $dataset_path . "?where=$searchTerm&?limit=1";

        //cURL
        $ch1 = curl_init($url0);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $gareResponse = curl_exec($ch1);
        if (curl_errno($ch1)) {
            echo "Erreur cURL: " . curl_error($ch1);
            die();
        }
        $liste_des_gares = json_decode($gareResponse, true);
        curl_close($ch1);

        if(count($liste_des_gares["results"]) <= 0)
        {
            return array();
        }
        $gare = $liste_des_gares["results"][0]["code_uic"];
        $affGare = $liste_des_gares["results"][0]["libelle"]; 

        // retourne le nom de la gare
        setcookie("lastDepName", $affGare, time() + (86400 * 30));

        //API URL
        // pour vérifier manuellement : https://e9d5c3e8-6cfe-4725-8914-edda6d54d892@api.sncf.com/v1/coverage/sncf/stop_areas/stop_area:SNCF:87276535/departures
        $url = "https://$apiKey@api.sncf.com/v1/coverage/sncf/stop_areas/stop_area:SNCF:$gare/departures";

        // deuxieme session cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "Erreur cURL: " . curl_error($ch);
            die();
        }
        $data = json_decode($response, true);
    }

    if($data === null)
    {
        $data = array();
    }
    curl_close($ch);
    return $data;
}

/**
 * Permet l'affichage du cookie si il existe et qu'aucune entrée n'a été faite dans le champ de recherche.
 *
 * @return string l'affichage au format HTML.
 */
function lastDepartureSearch() : string
{
    if(isset($_COOKIE['lastDeparture']) && !isset($_GET['q']))
    {
        return $_COOKIE['lastDeparture'];
    }
    else if(isset($_GET['q'])) {
        return departures(departuresAPIRequest());
    }
    return "<h2>premiere visite ? commencez par entrer un nom de gare dans le champ ci dessus !</h2>";
}

/**
 * gère l'affichage de la dernière session (si elle existe, et que rien n'a été entré)
 *
 * @return string le h1 à afficher
 */
function lastDepartureName() : string
{
    if(isset($_COOKIE['lastDeparture']) && !isset($_GET['q']))
    {
        return $_COOKIE['lastDepName'];
    }
    else if(isset($_GET['q'])) {
        return $_GET['q'];
    }
    return "Recherche de Départs";
}
/**
 * Permet l'affichage d'une gare via un appel à l'API d'OpenStreetMap
 *
 * @param float $latitude la latitude de la gare
 * @param float $longitude la longitude de la gare
 * @param integer $zoom le niveau de zoom de la map
 * @param integer $largeur la largeur en pixels de la map
 * @param integer $hauteur la hauteur en pixels de la map
 * @return string le code html d'implémentation de la carte.
 */
function afficherCarte(float $latitude, float $longitude, int $zoom = 10, int $largeur = 600, int $hauteur = 400) : string
 {
    // Création de l'URL pour afficher la carte OpenStreetMap avec un marqueur à la pos spécifiée
    $url = "https://www.openstreetmap.org/export/embed.html?bbox=" . ($longitude-0.01) . "," . ($latitude-0.01) . "," . ($longitude+0.01) . "," . ($latitude+0.01) . "&layer=mapnik";

    // Ajout des marqueurs à l'URL
    $url .= "&amp;marker=$latitude,$longitude";

    // Affichage de la carte dans un iframe
    $map = "<iframe width=\"$largeur\" height=\"$hauteur\" src=\"$url\"></iframe>";
    return $map;
}

/**
 * Permet l'affichage des informations disponibles d'une gare. Cela comprend, localisation, infos d'identification, et les horaires.
 *
 * @return string le code html d'affichage. 
 */
function rechercheInfoGare() : string
{
    if(isset($_GET['search'])) {
        $searchTerm = urlencode($_GET['search']);
        $base_path = "https://ressources.data.sncf.com/api/explore/v2.1";
        $dataset_path = "/catalog/datasets/gares-de-voyageurs/records";
        $horaires_dataset_path = "/catalog/datasets/horaires-des-gares1/records";

        $url = $base_path . $dataset_path . "?limit=100&where=codeinsee%20like%20%22$searchTerm%22%20OR%20nom%20like%20%22$searchTerm%22";
        echo "<a href=\"$url\">appel</a>";


        // Appel à l'API
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Vérifier si les données ont été récupérées avec succès et si elles existent
        if(isset($data['results']) && count($data['results']) > 0) {
            // Affichage des résultats
            $html = "<h1>Résultats de la recherche :</h1>";
            foreach($data['results'] as $result) {
                $html .= "<h2>Informations sur la gare :</h2>";
                foreach($result as $key => $value) {
                    if(is_array($value)) {
                        // Si la valeur est un tableau (par exemple, position géographique)
                        $html .="<p>$key :</p><ul>";
                        foreach($value as $subKey => $subValue) {
                            $html .= "<li>$subKey : $subValue</li>";
                        }
                        $html .= "</ul>";
                    } else {
                        $html .= "<p>$key : $value</p>";
                    }
                }
                $lon = $result['position_geographique']['lon'];
                $lat = $result['position_geographique']['lat'];
                $html .= afficherCarte($lat, $lon);


                // Récupérer le nom normal de la gare pour la recherche d'horaires
                $nom_gare = urlencode($result['nom']);

                // Construire l'URL de requête pour les horaires de la gare
                $url_horaires = $base_path . $horaires_dataset_path . "?where=nom_normal%20like%20%22$nom_gare%22";

                // Appel à l'API pour les horaires de la gare
                $response_horaires = file_get_contents($url_horaires);
                $data_horaires = json_decode($response_horaires, true);

                // Vérifier si les horaires de la gare ont été récupérés avec succès et si elles existent
                if(isset($data_horaires['results']) && count($data_horaires['results']) > 0) {
                    
                    // horaires de la gare, sous forme de tableau
                    $html .= "<h2>Horaires de la gare :</h2>";
                    
                    $html .= "<table>";
                    $html .= "<thead>
                        <tr>
                            <th>jour</th>
                            <th>horaires normaux</th>
                            <th>horaires en jour férié</th>
                        </tr>
                    </thead><tbody>";
                    foreach($data_horaires['results'] as $horaire) {
                        $html .= "<tr><td>" . $horaire['jour'] . "</td>";
                        $html .= "<td>".$horaire['horaire_normal']."</td>";
                        if(isset($horaire['horaire_ferie']) && ($horaire['horaire_ferie'] !== null)) {
                            $html .= "<td>" . $horaire['horaire_ferie'] . "</td></tr>";
                        }
                    }
                    $html .= "</tbody></table>";
                } else {
                    $html .= "<p>Aucun horaire trouvé pour cette gare.</p>";
                }
            }
            updateStats($nom_gare);
        } else {
            $html = "<p>Aucune donnée trouvée.</p>";
        }
        setcookie('lastInfoSearch',$html,time() + (86400 * 30));
    
    // si le champ de recherche est vide, on vérifie la présence d'un cookie d'une précédente session
    } else if(isset($_COOKIE['lastInfoSearch']) && !isset($_GET['search'])) {
        $html = $_COOKIE['lastInfoSearch'];

    // si on arrive ici, il s'agit probablement d'un nouvel utilisateur (ou d'un ancien, puisque les cookies sont conservés pendant un mois, avant d'etre supprimés)
    } else {
        $html = "<h1> Entrez un nom de gare pour commencez</h1>";
    }        
    return $html;
}

/**
 * Cette fonction met à jour les statistiques de recherche de gare dans un fichier CSV
 *
 * Si la gare a déjà été recherchée, on incrémente le nombre de recherches associé, si c'est une première recherche, on ajoute une nouvelle ligne au fichier.
 * @param string $nomGare la gare recherchée.
 * @return void
 */
function updateStats(string $nomGare) : void
{
    // on ouvre les fichiers : le fichier original en lecture, et un fichier temporaire en écriture
    $oldCSVFile = fopen('./data/statsRecherche.csv', 'r');
    $newCSVFile = fopen('./data/tempStats.csv', 'w');
    $modified = false;
    // on parcourt tout le fichier en modifiant le nombre de visite si la gare est trouvée, puis on écrit la ligne dans le fichier temporaire
    while (($line = fgetcsv($oldCSVFile)) !== false)
    {
        if ($line[0] === $nomGare)
        {
            $line[1]++;
            $modified = true;
        }
        fputcsv($newCSVFile, $line);
    }
    // si on a rien modifié, on ajoute au fichier temporaire une nouvelle ligne avec le nom de la gare, et un compteur de recherche à 1
    if(!$modified)
    {
        $line = [$nomGare,1];
        fputcsv($newCSVFile,$line);
    }
    // on ferme les 2 fichiers, on supprime l'original, et le temporaire devient le nouvel "original"
    fclose($oldCSVFile);
    fclose($newCSVFile);
    unlink('./data/statsRecherche.csv');
    rename('./data/tempStats.csv','./data/statsRecherche.csv');
}

/**
 * récupère les statistiques stockées dans le fichier CSV, et fait un classement des gares les plus recherchées à partir de celles-ci.
 *
 * @return array le tableau html du classement.
 */
function getStats() : array
{
    // on récupère le contenu du fichier csv, et on le met dans un tableau, et on trie ce tableau par ordre décroissant
    $CSVFile = fopen('./data/statsRecherche.csv', 'r');
    $ranking = [];
    while(($line = fgetcsv($CSVFile)) !== false)
    {
        $ranking[$line[0]] = $line[1];
    }
    arsort($ranking);
    return $ranking;
    
}

/**
 * retourne le code HTML de la datalist avec toutes les gares de France.
 *
 * @return string le code html de la datalist
 */
function getDatalist(string $id) : string
{
    $html = "<datalist id=\"$id\">";
    $file = fopen('./data/liste_gares.csv','r');
    while(($line = fgetcsv($file)) !== false)
    {
        $html .= '<option value="';
        $html .= $line[0] . '">' . PHP_EOL;
        //$html .= '"></option>';
    }
    $html .= '</datalist>';
    fclose($file);
    return $html;
}

function getGraph() : string
{
    $html = '';
    //dimensions du graph
    $data = (array) getStats();
    $width = "100%";
    $height = 50 * count($data) + 10;
    $margin = 10;

    //hauteur de chaque barre + 
    $barHeight = 40;
    $maxWidth = 75;

    $html = PHP_EOL . "<svg width=\"$width\" height=\"$height\"style=\"border: 1px solid #ffffff; display: block;\">" . PHP_EOL;
    $y = $margin;
    foreach($data as $nom_gare => $nombre_visite)
    {
        $nom_gare = urldecode($nom_gare);
        $barLength = ($nombre_visite / max($data)) * $maxWidth ;
        $barPercent = "$barLength%";
        $xVal = $barLength + 2;
        $posX = "$xVal%";
        $posY = $y + $barHeight / 1.33;
        $html .= "<rect x=\"$margin\" y=\"$y\" width=\"$barPercent\" height=\"$barHeight\" fill=\"#42a5f5\"/>" . PHP_EOL;
        $html .= "<text x=\"$margin\" y=\"$posY\" fill=\"white\" font-size=\"30\"> $nombre_visite</text>" . PHP_EOL;
        $html .= "<text x=\"$posX\" y=\"$posY\" fill=\"white\" font-size=\"30\"> $nom_gare</text>" . PHP_EOL;
        $y += $barHeight + $margin;
    }
    $html .= "</svg>";
    return $html;
}
?>