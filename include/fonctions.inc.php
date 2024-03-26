<?php 

/**
 * Fonction pour obtenir l'adresse IP du visiteur.
 * 
 * @return string Adresse IP du visiteur.
 */
function getVisitorIP(): string {
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
function fetchAPOD(): string {
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
function fetchIpInfoLocation(): string {
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
function fetchGeoPluginLocationJson(): string {
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
function fetchGeoPluginLocationXml(): string {
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
function getGeoPluginLocationCsvCode(): string {
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
function gestionTheme(string $src): string {
    // Vérification si le mode a été choisi
    if(isset($_GET['mode'])) {
        // Mode nuit choisi
        if($_GET['mode'] === 'nuit') {
            // Définition du cookie pour le mode nuit
            setcookie('mode', 'nuit', time() + (86400 * 30), "/{$src}/");
            return 'nuit';
        }
        // Mode jour choisi
        else if($_GET['mode'] === 'jour') {
            // Définition du cookie pour le mode jour
            setcookie('mode', 'jour', time() + (86400 * 30), "/{$src}/");
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

?>