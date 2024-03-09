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
            $apiKey = 'YOUR_NASA_API_KEY';
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

    <h2>Localisation par adresse IP avec GeoPlugin - JSON</h2>
    <div id="ipLocationContainerJSON">
        <?php
            $visitorIP = getVisitorIP();
            $geoPluginJsonUrl = "http://www.geoplugin.net/json.gp?ip={$visitorIP}";

            try {
                $geoPluginJsonResponse = file_get_contents($geoPluginJsonUrl);
                $geoPluginData = json_decode($geoPluginJsonResponse);

                // Afficher les données JSON de GeoPlugin
                echo '<pre>';
                print_r($geoPluginData);
                echo '</pre>';
            } catch (Exception $e) {
                echo 'Erreur lors du chargement de la localisation par adresse IP (JSON): ' . $e->getMessage();
            }
        ?>
    </div>

    <hr>

    <h2>Localisation par adresse IP avec GeoPlugin - XML</h2>
    <div id="ipLocationContainerXML">
        <?php
            $visitorIP = getVisitorIP();
            $geoPluginXmlUrl = "http://www.geoplugin.net/xml.gp?ip={$visitorIP}";

            try {
                $geoPluginXmlResponse = file_get_contents($geoPluginXmlUrl);
                $geoPluginXml = simplexml_load_string($geoPluginXmlResponse);

                // Afficher les données XML de GeoPlugin
                echo '<pre>';
                print_r($geoPluginXml);
                echo '</pre>';
            } catch (Exception $e) {
                echo 'Erreur lors du chargement de la localisation par adresse IP (XML): ' . $e->getMessage();
            }
        ?>
    </div>

    <hr>

    <h2>Localisation par adresse IP avec GeoPlugin - CSV</h2>
    <div id="ipLocationContainerCSV">
        <?php
            $visitorIP = getVisitorIP();
            $geoPluginCsvUrl = "http://www.geoplugin.net/csv.gp?ip={$visitorIP}";

            try {
                $geoPluginCsvResponse = file_get_contents($geoPluginCsvUrl);

                // Afficher les données CSV de GeoPlugin
                echo '<pre>';
                echo $geoPluginCsvResponse;
                echo '</pre>';
            } catch (Exception $e) {
                echo 'Erreur lors du chargement de la localisation par adresse IP (CSV): ' . $e->getMessage();
            }
        ?>
    </div>

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
    ?>
</body>
</html>
