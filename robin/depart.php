<?php
    /**
 * Cette fonction associe le nom de chaque gare à son code UIC.
 * 
 * @return array Le tableau associatif contenant le nom de chaque gare comme clé et son code UIC comme valeur.
 */
function getGareCodes(): array
{
    return [
        "Aix-en-Provence TGV" => "87775003",
        "Aix-les-Bains-Le Revard" => "87472000",
        "Angers Saint-Laud" => "87478011",
        "Angoulême" => "87581003",
        "Annecy" => "87758001",
        "Avignon TGV" => "87771007",
        "Belfort-Montbéliard TGV" => "87115012",
        "Besançon Franche-Comté TGV" => "87182002",
        "Bordeaux Saint-Jean" => "87585000",
        "Bourg-en-Bresse" => "87776007",
        "Brest" => "87471003",
        "Brive-la-Gaillarde" => "87595000",
        "Cannes" => "87319009",
        "Chambery-Challes-les-Eaux" => "87775489",
        "Clermont-Ferrand" => "87591000",
        "Colmar" => "87182001",
        "Dijon Ville" => "87686000",
        "Gare de Lyon" => "87775007",
        "Gare de l'Est" => "87271008",
        "Gare du Nord" => "87271007",
        "Gare Montparnasse" => "87391003",
        "Gare Saint-Lazare" => "87384008",
        "Grenoble" => "87778008",
        "La Rochelle Ville" => "87481004",
        "Le Havre" => "87415000",
        "Le Mans" => "87471004",
        "Lille Europe" => "87271003",
        "Lille Flandres" => "87271002",
        "Limoges-Bénédictins" => "87594001",
        "Lyon Part-Dieu" => "87775008",
        "Lyon Perrache" => "87751006",
        "Macon-Loché TGV" => "87775009",
        "Marseille Saint-Charles" => "87751003",
        "Metz Ville" => "87182003",
        "Montpellier Saint-Roch" => "87775002",
        "Mulhouse Ville" => "87185000",
        "Nancy Ville" => "87182004",
        "Nantes" => "87478020",
        "Nice Ville" => "87756008",
        "Nîmes" => "87775006",
        "Orléans" => "87584007",
        "Paris-Austerlitz" => "87547000",
        "Paris-Bercy Bourgogne-Pays d'Auvergne" => "87547303",
        "Paris-Gare de Lyon" => "87775007",
        "Paris-Montparnasse" => "87391003",
        "Paris-Nord" => "87271007",
        "Paris-Saint-Lazare" => "87384008",
        "Perpignan" => "87775016",
        "Poitiers" => "87582002",
        "Quimper" => "87471007",
        "Reims" => "87212000",
        "Rennes" => "87476004",
        "Rouen-Rive-Droite" => "87415002",
        "Saint-Brieuc" => "87471005",
        "Saint-Etienne Châteaucreux" => "87777001",
        "Saint-Malo" => "87476002",
        "Strasbourg" => "87271001",
        "Tarbes" => "87686000",
        "Toulon" => "87775013",
        "Toulouse Matabiau" => "87775005",
        "Tours" => "87575006",
        "Valence TGV" => "87775010",
        "Vannes" => "87471006",
        "Versailles-Chantiers" => "87393505",
        "Versailles-Rive-Gauche-Château de Versailles" => "87393518",
        "Vichy" => "87686000",
        "Vitré" => "87476007",
        "Voreppe" => "87775489"
        // Ajoutez d'autres gares au besoin
    ];
}
    /**
 * Cette fonction recherche le code UIC d'une gare à partir de son nom.
 * 
 * @param string $nom Le nom de la gare.
 * @return string Le code UIC de la gare trouvée, ou une chaîne vide si la gare n'est pas trouvée.
 */
function getCodeUIC(string $nom): string
{
    $url = "https://ressources.data.sncf.com/api/records/1.0/search/?dataset=liste-des-gares&facet=code_uic&refine.nom_gare=" . urlencode($nom);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "Erreur cURL: " . curl_error($ch);
        die();
    }
    $liste_des_gares = json_decode($response, true);
    if (isset($liste_des_gares["records"][0]["fields"]["code_uic"])) {
        return $liste_des_gares["records"][0]["fields"]["code_uic"];
    } else {
        return ''; // Retourne une chaîne vide si la gare n'est pas trouvée
    }
}

    /**
     * Cette fonction effectue une requête à l'API SNCF pour obtenir les départs de trains pour une gare donnée.
     * 
     * @param string $gare Le nom de la gare pour laquelle récupérer les départs.
     * @return array Les données des départs des trains pour la gare donnée.
     */
    function getDepartures(string $gare): array
    {
        $codeUIC = getCodeUIC($gare);
        $apiKey = "e9d5c3e8-6cfe-4725-8914-edda6d54d892";
        $url = "https://$apiKey@api.sncf.com/v1/coverage/sncf/stop_areas/stop_area:SNCF:$codeUIC/departures";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "Erreur cURL: " . curl_error($ch);
            die();
        }
        curl_close($ch);
        
        return json_decode($response, true);
    }

    /**
     * Cette fonction génère le tableau HTML pour afficher les départs des trains.
     * 
     * @param array $departures Les données des départs des trains.
     * @return string Le code HTML du tableau.
     */
    function formatDepartures(array $departures): string
    {
        $html = '<table>';
        $html .= '<thead><tr><th>Heure</th><th>Destination</th><th>Ligne</th><th>Train</th></tr></thead>';
        $html .= '<tbody>';
        
        foreach ($departures['departures'] as $departure) {
            $heureDepart = date('H:i', strtotime($departure['stop_date_time']['departure_date_time']));
            $destination = $departure['display_informations']['direction'];
            $ligne = $departure['route']['line']['code'] ?? '';
            $train = $departure['route']['name'] ?? '';
            
            $html .= "<tr><td>$heureDepart</td><td>$destination</td><td>$ligne</td><td>$train</td></tr>";
        }
        
        $html .= '</tbody></table>';
        
        return $html;
    }
	?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horaires des départs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Horaires des départs</h1>
    
    <form method="GET">
        <label for="gare">Nom de la gare :</label>
        <input type="text" id="gare" name="gare" placeholder="Entrez le nom d'une gare">
        <button type="submit">Rechercher</button>
    </form>

    <?php
    // Récupérer les départs pour la gare spécifiée par l'utilisateur
    $gareSelectionnee = $_GET['gare'] ?? "Gare du Nord"; // Par défaut, Gare du Nord
    $departures = getDepartures($gareSelectionnee);

    // Afficher les départs dans un tableau HTML
    echo formatDepartures($departures);
    ?>
</body>
</html>
