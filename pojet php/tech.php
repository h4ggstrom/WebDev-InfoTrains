<?php 
	declare(strict_types=1);
	$title = "UJR Acceuil";
	$h1 = "projet php";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
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
<main>
<section>
	<h2>page techinique des API</h2>
	<article>
	<h3>Astronomy Picture of The Day - Developer Page</h3>

    <?php
    $apiKey = 'ViJkzG7JONaWOcpDw4QYjGZ8pbNCPbGIzhQ5ypSr';
    $currentDate = date('Y-m-d');
    $apodApiUrl = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}&date={$currentDate}";

    try {
        $apodResponse = file_get_contents($apodApiUrl);
        $apodData = json_decode($apodResponse);

        if ($apodData->media_type === 'image') {
            // Si c'est une image, l'afficher
			echo "<figure>";
            echo "<img src=\"{$apodData->url}\" alt=\"APOD\"/>";
			echo "<figcaption>image du jour Nasa</figcaption>";
			echo "</figure>";
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
	</article>
	
	<article>
	<h3>Localisation par adresse IP avec ipinfo.io</h3>
        <?php
            $visitorIP = getVisitorIP();
            $ipinfoApiUrl = "https://ipinfo.io/{$visitorIP}/geo";

            try {
                $ipinfoResponse = file_get_contents($ipinfoApiUrl);
                $ipinfoData = json_decode($ipinfoResponse);

                $city = $ipinfoData->city;
                $region = $ipinfoData->region;
                $country = $ipinfoData->country;
                $postalCode = $ipinfoData->postal;
                $latitude = $ipinfoData->loc ? explode(',', $ipinfoData->loc)[0] : '';
                $longitude = $ipinfoData->loc ? explode(',', $ipinfoData->loc)[1] : '';

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
	</article>
	
	<article>
	
	<h3>Localisation par adresse IP avec GeoPlugin - XML</h3>
		<?php
$visitorIP = getVisitorIP();
$geoPluginXmlUrl = "http://www.geoplugin.net/xml.gp?ip={$visitorIP}";

try {
    $geoPluginXmlResponse = file_get_contents($geoPluginXmlUrl);
    $geoPluginXml = simplexml_load_string($geoPluginXmlResponse);

    // Extraire des informations spécifiques du XML
    $city = $geoPluginXml->geoplugin_city;
    $region = $geoPluginXml->geoplugin_region;
    $country = $geoPluginXml->geoplugin_countryName;

    // Afficher les informations de localisation
    echo "<p>City: $city</p>";
    echo "<p>Region: $region</p>";
    echo "<p>Country: $country</p>";

} catch (Exception $e) {
    echo 'Erreur lors du chargement de la localisation par adresse IP (XML): ' . $e->getMessage();
}
?>


	<h3>Localisation par adresse IP avec GeoPlugin - CSV</h3>
		<?php
		$visitorIP = getVisitorIP();
		$geoPluginCsvUrl = "http://www.geoplugin.net/csv.gp?ip={$visitorIP}";

		try {
			$geoPluginCsvResponse = file_get_contents($geoPluginCsvUrl);

			// Afficher les données CSV de GeoPlugin
			echo '<p>CSV Data:</p>';
			echo '<pre>';
			echo $geoPluginCsvResponse;
			echo '</pre>';
		} catch (Exception $e) {
			echo 'Erreur lors du chargement de la localisation par adresse IP (CSV): ' . $e->getMessage();
		}
		?>


	<h3>Localisation par adresse IP avec GeoPlugin - JSON</h3>
		<?php
		$visitorIP = getVisitorIP();
		$geoPluginJsonUrl = "http://www.geoplugin.net/json.gp?ip={$visitorIP}";

		try {
			$geoPluginJsonResponse = file_get_contents($geoPluginJsonUrl);
			$geoPluginJsonData = json_decode($geoPluginJsonResponse, true);

			// Extraire des informations spécifiques du JSON
			$city = $geoPluginJsonData['geoplugin_city'];
			$region = $geoPluginJsonData['geoplugin_region'];
			$country = $geoPluginJsonData['geoplugin_countryName'];

			// Afficher les informations de localisation
			echo "<p>City: $city</p>";
			echo "<p>Region: $region</p>";
			echo "<p>Country: $country</p>";

		} catch (Exception $e) {
			echo 'Erreur lors du chargement de la localisation par adresse IP (JSON): ' . $e->getMessage();
		}
		?>
	
	</article>
	
	<article>
	
	<h3>Localisation par adresse IP avec whatismyip.com</h3>
       <?php
		$visitorIP = getVisitorIP();
		$apiKey = "231acbcd469a271aeba0b4c86f01b12c";

		// Vérifier si l'adresse IP est IPv6
		if (filter_var($visitorIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			echo "<p>IPv6 n'est pas pris en charge par cette démo.</p>";
		} else {
			$whatismyipApiUrl = "https://api.whatismyip.com/ip-address-lookup.php?key={$apiKey}&input={$visitorIP}&output=xml";

			try {
				// Utiliser simplexml_load_file pour charger directement depuis l'URL
				$xml = simplexml_load_file($whatismyipApiUrl);

				// Vérifier si le chargement du XML est réussi
				if ($xml === false) {
					foreach (libxml_get_errors() as $error) {
						echo "Erreur XML : ", $error->message;
					}
					libxml_clear_errors();
				} else {
					// Extraire les informations nécessaires du flux XML
					$city = (string)$xml->GeoCity;
					$region = (string)$xml->GeoRegion;
					$country = (string)$xml->GeoCountry;
					$postalCode = (string)$xml->GeoPostalCode;
					$latitude = (string)$xml->GeoLatitude;
					$longitude = (string)$xml->GeoLongitude;

					$locationInfo = "Vous êtes situé à {$city}, {$region}, {$country}, {$postalCode}. Coordonnées géographiques : Latitude {$latitude}, Longitude {$longitude}.";

					echo "<p>{$locationInfo}</p>";
				}
			} catch (Exception $e) {
				echo 'Erreur lors du chargement de la localisation par adresse IP (XML): ' . $e->getMessage();
			}
		}
		?>
	
	</article>
	
</section>

</main>

<?php

	require "include/footer.inc.php";

?>