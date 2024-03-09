<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Page - APOD and IP Location</title>
</head>
<body>
    <h1>Astronomy Picture of The Day - Developer Page</h1>

    <div id="apodImageContainer">
        <?php
            // Remplacez 'YOUR_NASA_API_KEY' par votre propre clé API de la NASA
            $apiKey = 'ViJkzG7JONaWOcpDw4QYjGZ8pbNCPbGIzhQ5ypSr';
            $apodApiUrl = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}&date=2024-02-23";

            try {
                $apodResponse = file_get_contents($apodApiUrl);
                $apodData = json_decode($apodResponse);

                if ($apodData->media_type === 'image') {
                    // Si c'est une image, l'afficher
                    echo "<img src=\"{$apodData->url}\" alt=\"APOD\">";
                } elseif ($apodData->media_type === 'video') {
                    // Si c'est une vidéo, utiliser la balise vidéo HTML5
                    echo "<video width=\"100%\" height=\"auto\" controls><source src=\"{$apodData->url}\" type=\"video/mp4\"></video>";
                } else {
                    echo 'Type de média non pris en charge.';
                }
            } catch (Exception $e) {
                echo 'Erreur lors du chargement des données APOD: ' . $e->getMessage();
            }
        ?>
    </div>

    <hr>

    <h2>Localisation par adresse IP</h2>
    <div id="ipLocationContainer">
        <?php
            // Fonction pour récupérer l'adresse IP du visiteur côté serveur
            function getVisitorIP() {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                return $ip;
            }

            $visitorIP = getVisitorIP();
            $ipLocationUrl = "http://www.geoplugin.net/xml.gp?ip={$visitorIP}";

            try {
                $ipLocationResponse = file_get_contents($ipLocationUrl);
                $xml = simplexml_load_string($ipLocationResponse);

                $city = $xml->geoplugin_city;
                $region = $xml->geoplugin_region;
                $country = $xml->geoplugin_countryName;
                $postalCode = $xml->geoplugin_areaCode;
                $latitude = $xml->geoplugin_latitude;
                $longitude = $xml->geoplugin_longitude;

                $locationInfo = "Vous êtes situé à ";
                if (!empty($city)) {
                    $locationInfo .= "{$city}, ";
                }
                $locationInfo .= "{$region}, {$country}, {$postalCode}. Coordonnées géographiques : Latitude {$latitude}, Longitude {$longitude}.";

                echo "<p>{$locationInfo}</p>";
            } catch (Exception $e) {
                echo 'Erreur lors du chargement de la localisation par adresse IP: ' . $e->getMessage();
            }
        ?>
    </div>
</body>
</html>