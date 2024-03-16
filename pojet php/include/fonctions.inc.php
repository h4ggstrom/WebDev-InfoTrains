<?php
	const DEFAULT_TABLE_SIZE = 10;


	/**
	* Valide si une valeur est comprise entre deux valeurs.
	*
	* @param int $value La valeur à valider.
	*
	* @return bool Renvoie true si la valeur est valide, sinon un message d'erreur.
	*/
	function verifValeur($value) : bool {
		if (!is_int($value) || $value < DEFAULT_TABLE_SIZE-10 || $value > DEFAULT_TABLE_SIZE+10) {
			return false;
		}

		return true;
	}
	
	/**
	* Cette fonction génère une table de multiplication sous la forme d'un tableau HTML.
	*
	* @param int $lignes Le nombre de lignes de la table (par défaut 10)
	* @param int $colonnes Le nombre de colonnes de la table (par défaut 10)
	* @return string Le code HTML de la table de multiplication
	*/
	function multiplicationTable(int $lignes = DEFAULT_TABLE_SIZE, int $colonnes = DEFAULT_TABLE_SIZE): string {
		if (!verifValeur($lignes)){
			$lignes=DEFAULT_TABLE_SIZE;
		}
		if (!verifValeur($colonnes)){
			$colonnes=DEFAULT_TABLE_SIZE;
		}
		$htmlTable = '<table class="ex1">' . "\n";
		$htmlTable .="\t<caption>table de multiplication</caption>\n";
		
    
		$htmlTable .= "\t<thead>\n\t\t<tr>\n\t\t<th class=".'"empty"'."></th>";

		for ($i = 1; $i <= $colonnes; $i++) {
			$htmlTable .= "\n\t\t\t<th>$i</th>";
		}

		$htmlTable .= "\n\t\t</tr>\n\t</thead>\n";
		
		$htmlTable .= "\t<tbody>\n";
		for ($i = 1; $i <= $lignes; $i++) {
			$htmlTable .= "\t\t<tr>\n\t\t\t<th>$i</th>";
	
			for ($j = 1; $j <= $colonnes; $j++) {
				$htmlTable .= "\n\t\t\t<td>" . ($i * $j) . "</td>";
			}

			$htmlTable .= "\n\t\t</tr>\n";
		}
		$htmlTable .= "\t</tbody>\n</table>";

		return $htmlTable;
	}
	
	/**
	* Génère une table ASCII.
	*
	* @return string La table ASCII sous forme de tableau HTML.
	*/
	function generateASCIITable(): string {
		$html = '<table>' . PHP_EOL;
		$html .="\t<caption>tableau ASCII</caption>\n";
		$html .= "\t" . '<tr>' . PHP_EOL;
		$html .= "\t\t" . '<th class="empty"></th>' . PHP_EOL;

		for ($i = 0; $i <= 15; $i++) {
			$hex = dechex($i);
			$html .= "\t\t" . '<th class="hex-header">' . strtoupper($hex) . '</th>' . PHP_EOL;
		}

		$html .= "\t" . '</tr>' . PHP_EOL;

		for ($row = 2; $row <= 7; $row++) {
			$html .= "\t" . '<tr>' . PHP_EOL;

			$html .= "\t\t" . '<td class="first-column">' . $row . '</td>' . PHP_EOL;

			for ($col = 0; $col <= 15; $col++) {
				$asciiValue = $row * 16 + $col;

				$char = getSpecialCharacter($asciiValue);

				$value = htmlspecialchars($char, ENT_QUOTES, 'UTF-8');
				$class = getCharClass($asciiValue);

				$html .= "\t\t" . '<td class="' . $class . '">' . $value . '</td>' . PHP_EOL;
			}

			$html .= "\t" . '</tr>' . PHP_EOL;
		}	

		$html .= '</table>' . PHP_EOL;

		return $html;
	}

	/**
	* Obtient la classe CSS correspondant à la valeur ASCII.
	*
	* @param int $asciiValue La valeur ASCII.
	* @return string La classe CSS correspondante.
	*/
	function getCharClass(int $asciiValue): string {
		if ($asciiValue >= 48 && $asciiValue <= 57) {
			return 'digit';
		} elseif ($asciiValue >= 65 && $asciiValue <= 90) { 
			return 'uppercase';
		} elseif ($asciiValue >= 97 && $asciiValue <= 122) { 
			return 'lowercase';
		} else {
			return '';
		}
	}

	/**
	* Obtenir le caractère spécial correspondant à la valeur ASCII.
	*
	* @param int $asciiValue La valeur ASCII.
	* @return string Le caractère spécial correspondant.
	*/
	function getSpecialCharacter(int $asciiValue): string {
		switch ($asciiValue) {
			case 39:
				return "'";
			case 60:
				return '<';
			case 127:
				return ' ';
			default:
				return html_entity_decode('&#' . $asciiValue . ';', ENT_COMPAT, 'UTF-8');
		}
	}
	
	/*
	*cette fonction permet de générer une liste de hello.
	*@param $nb est le nombre d'occurence de la boucle et donc le nombre de hello qui seront affiché
	*@author louis gallet
	*@return $liste est le code html de la liste
	*/
	function compteur(int $nb = DEFAULT_TABLE_SIZE): string {
		$liste = "<ul>";
		for($i=1;$i<$nb;$i++){
			$message = "hello number".$i;
			$liste .= "\n\t<li>$message</li>";
		}
		$liste .= "\n</ul>\n";
		return $liste;
	}
	
	/*
	*cette fonction perment de convertire un valeur en hexadécimal vers de l'octal, du décimal et du binaire
	*@param $valeur_hex est la valeur du caractère en htm
	*@author louis gallet
	*@return $sol est le code html des 2 paragraphe que contiennent la conversion
	*/
	function conversions(string $valeur_hex): string {
    	$dec = hexdec($valeur_hex);
    	$chr = chr($dec);
    	$sol = "<p> 0x$valeur_hex = $dec = $chr </p> \n";
		$dec1 = ord($chr);
		$hex = dechex($dec1);
		$sol .= "<p> $chr = $dec1 = 0x$hex </p> \n";
		return $sol;
	}
	
	/*
	*cette fonction fait la liste des 15 premiers caractères héxadécimal
	*@author louis gallet
	*@return $liste est le code html de la liste des caractères héxadécimal
	*/
	function hexa(): string {
		$liste = '<ul class="horizontal-list">';
    	for ($i = 0; $i <= 15; $i++) {
			$hexa = dechex($i);
			$liste .= "\n\t<li>$hexa</li>";
    	}
    	$liste .= "\n</ul>\n";
    	return $liste;
	}
	
	/*
	*cette fonction fait un tableau de conversion des décimal de 0 a 17
	*@author louis gallet
	*@return $table est le code html du tableau des caractères héxadécimal, binaire, octal et décimal de 0 a 17
	*/
	function creat_Table(int $nb = DEFAULT_TABLE_SIZE): string {
		if (!verifValeur($nb)){
			$nb=DEFAULT_TABLE_SIZE;
		}
		$table = '<table>';
		$table .= "\n\t<caption>conversion entre différentes bases</caption>\n";
		$table .= "\t<thead>\n\t\t<tr>\n\t\t\t<th>Binaire</th>\n\t\t\t<th>octal</th>\n\t\t\t<th>décimal</th>\n\t\t\t<th>hexadécimal</th>\n\t\t</tr>\n\t</thead>";
		$table .= "\n\t<tbody>";
    
		for ($i = 0; $i <= $nb; $i++) {
			$decimal = $i;
			$hexa = sprintf("%02X", $i);
			$octal = sprintf("%02o", $i);
			$binaire = sprintf("%08b", $i);
			$table .= "\n\t\t<tr>\n\t\t\t<td>$binaire</td>\n\t\t\t<td>$octal</td>\n\t\t\t<td>$decimal</td>\n\t\t\t<td>$hexa</td>\n\t\t</tr>";
		}
		$table .= "\n\t</tbody>";
    
		$table .= "\n</table>\n";
		return $table;
	}
	
	/**
	* Génère une liste HTML des noms des régions de France.
	*
	* @param string $listType Le type de liste à générer : 'ul' pour liste à puce (par défaut), 'ol' pour liste numérotée.
	*
	* @return string La liste HTML des noms des régions.
	*/
	function generateRegionList($listType = 'ul') {
		$regions = array(
			"Guadeloupe", 
			"Martinique", 
			"Guyane", 
			"La Réunion", 
			"Mayotte", 
			"Île-de-France", 
			"Centre-Val de Loire",
			"Bourgogne-Franche-Comté", 
			"Normandie", "Hauts-de-France", 
			"Grand Est", 
			"Pays de la Loire", 
			"Bretagne", 
			"Nouvelle-Aquitaine", 
			"Occitanie", 
			"Auvergne-Rhône-Alpes", 
			"Provence-Alpes-Côte d’Azur", 
			"Corse"
		);

		$list = '';
		if ($listType === 'ul' || $listType === 'ol') {
			$list = "<$listType>\n";

			foreach ($regions as $region) {
				$list .= "<li>$region</li>\n";
			}

			$list .= "</$listType>\n";
		}

		return $list;
	}
	
	/**
	* Obtient les origines étymologiques du jour de la semaine et du mois de l'année actuels.
	*
	* @return array Un tableau associatif contenant les origines étymologiques du jour et du mois.
	*/
	function getOriginsOfCurrentDate() {
		
		// Tableau associatif pour les jours de la semaine
		$joursSemaine = array(
			'monday' => 'lundi viens de la Lune',
			'tuesday' => 'mardi viens de Mars',
			'wednesday' => 'mercredi viens de Mercure',
			'thursday' => 'jeudi viens de Jupiter',
			'friday' => 'vendredi viens de Vénus',
			'saturday' => 'samesi viens de Saturne',
			'sunday' => 'dimanche viens du Soleil'
		);

		// Tableau associatif pour les mois de l'année
		$moisAnnee = array(
			1 => "Janvier : provient du nom du dieu Janus, dieu des portes (de janua, « porte » en latin, selon Tertullien), 
			des passages et des commencements dans la mythologie romaine, représenté avec deux visages opposés, car il regarde 
			l'entrée et la sortie, la fin et le début d'une année. ",
			2 => "Février : du latin populaire febrarius, dérivé du latin classique februarius, issu du verbe februare « purifier ».
			Février est donc le mois des purifications. Voir aussi Apollon.",
			3 => "Mars : provient du dieu de la guerre Mars (le retour de la période permise pour entamer une guerre).",
			4 => "Avril : du latin aprilis « avril » qui peut avoir la signification d’« ouvrir », car c’est le mois où les fleurs s’ouvrent. 
			Aprilis (avril) était le deuxième mois du calendrier romain. Ce mois était dédié à la déesse grecque Aphrodite. Il devient graduellement,
			selon les pays, le quatrième mois de l’année lorsque, en 532, l’Église de Rome décida que l’année commence le 1er janvier ; voir Denys le Petit.
			(source ?)",
			5 => "Mai : du latin Maius (mensis) « le mois de mai », provient de la déesse Maïa, l'une des Pléiades et mère de Mercure.",
			6 => "Juin : vient du latin junius. Ce nom fut probablement donné en l’honneur de la déesse romaine Junon. À l’époque antique, 
			c’était le quatrième mois du calendrier romain.",
			7 => "Juillet : deux interprétations possibles : altération de l'ancien français juignet « juillet » proprement « petit juin » et du latin julius 
			(mensis), nom du septième mois de l'année (proprement « mois de Jules, en l'honneur de Jules César, né dans ce mois, réformateur du calendrier romain)
			», le gn de juignet passant alors en ll de juillet.",
			8 => "Juillet : deux interprétations possibles : altération de l'ancien français juignet « juillet » proprement « petit juin » 
			et du latin julius (mensis), nom du septième mois de l'année (proprement « mois de Jules, en l'honneur de Jules César, né dans ce mois,
			réformateur du calendrier romain) », le gn de juignet passant alors en ll de juillet.",
			9 => "Le mois de septembre (de septem (mensis) : septième mois) ",
			10 => "octobre : latin october (mensis) « octobre, huitième mois de l'année romaine » (dérivé de octo : « huit »), 
			qui peut également faire référence à l'empereur romain Octave ;",
			11 => "novembre (novem : « neuf » )",
			12 => " décembre (latin classique december, dérivé de decem : « dix », décembre étant le dixième mois de l'année romaine) ne se comprennent 
			qu’en commençant l'année à l'équinoxe de printemps, au mois de mars."
		);

		// Obtention de la date courante
		$jourActuel = strtolower(date('l')); // Jour de la semaine en minuscules
		$moisActuel = date('n'); // Mois de l'année en numérique

		// Récupération des origines étymologiques
		$origineJour = $joursSemaine[$jourActuel];
		$origineMois = $moisAnnee[$moisActuel];

		return array('jour' => $origineJour, 'mois' => $origineMois);
	}
	
	/**
	 * Fonction generateSafeWebPalette
	 * 
	 * Génère la palette web sécurisée de 216 couleurs.
	 * Chaque couleur est représentée par un code hexadécimal "#RRGGBB".
	 *
	 * @return array La palette web sécurisée
	 */
	function generateSafeWebPalette() {
		$palette = [];

		// Les valeurs possibles pour chaque composante de couleur (rouge, vert, bleu)
		$colorValues = [0, 51, 102, 153, 204, 255];

		// Générer les 216 couleurs en combinant les valeurs possibles pour chaque composante
		foreach ($colorValues as $red) {
			foreach ($colorValues as $green) {
				foreach ($colorValues as $blue) {
					// Utiliser sprintf pour formater les valeurs en hexadécimal
					$colorCode = sprintf("#%02X%02X%02X", $red, $green, $blue);
					$palette[] = $colorCode;
				}
			}
		}

		return $palette;
	}

	/**
	 * Fonction getContrastColor
	 * 
	 * Retourne une couleur de texte (blanc ou noir) en fonction de la luminosité de la couleur de fond.
	 *
	 * @param string $backgroundColor La couleur de fond en format hexadécimal
	 * @return string La couleur de texte en format hexadécimal
	 */
	function getContrastColor($backgroundColor) {
		// Convertir la couleur de fond en valeurs RGB
		list($r, $g, $b) = sscanf($backgroundColor, "#%02x%02x%02x");

		// Calculer la luminosité relative (utilisant la formule W3C)
		$luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

		// Choisir la couleur de texte en fonction de la luminosité
		return ($luminance > 0.5) ? '#000000' : '#ffffff';
	}

	/**
	 * Génère une table HTML à partir d'une palette de couleurs.
	 *
	 * Cette fonction crée une table avec des cellules colorées à partir d'une palette
	 * de couleurs spécifiée.
	 *
	 * @param array $palette Un tableau de couleurs à afficher dans la table.
	 * @return string Retourne une chaîne de caractères représentant le code HTML de la table.
	 */
	function generateTableHTML($palette) {
		$columns = 16; // Définir le nombre de colonnes
		$tableHTML = "\n<table>\n"."<caption>Palette de couleurs</caption>\n";

		for ($i = 0; $i < count($palette); $i++) {
			if ($i % $columns === 0) {
				$tableHTML .= "<tr>\n";
			}

			$backgroundColor = $palette[$i];
			$contrastColor = getContrastColor($backgroundColor);

			$tableHTML .= '<td style="background-color:' . $backgroundColor . '; color:' . $contrastColor . ';">' . $palette[$i] . "</td>\n";

			if (($i + 1) % $columns === 0) {
				$tableHTML .= "</tr>\n";
			}
		}

		// Vérifier s'il reste des cellules dans la dernière ligne
		if ($i % $columns !== 0) {
			// Remplir les cellules restantes avec des cellules vides
			while ($i % $columns !== 0) {
				$tableHTML .= '<td></td>';
				$i++;
			}
			$tableHTML .= "</tr>\n";
		}

		$tableHTML .= "</table>\n";

		return $tableHTML;
	}
	
	/**
	* Fonction : extraireInformationsURL
	* Description : Cette fonction prend une URL en entrée et extrait diverses informations telles que le protocole,
	*               le sous-domaine, le domaine, le TLD (Top Level Domain), et associe des valeurs personnalisées à certains TLDs.
	*
	* @param string $url L'URL à analyser.
	*
	* @return array Un tableau associatif contenant les informations extraites de l'URL.
	*/
	function extraireInformationsURL($url) : array  {
		// Analyser l'URL en composants
		$parsedUrl = parse_url($url);

		// Vérifier si l'URL a un protocole défini
		$protocol = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : '';

		// Vérifier si l'URL a un chemin spécifié
		$path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
		
		// Extract the host
		$host = parse_url($url, PHP_URL_HOST);
			
		$ip = getIpFromUrl($url);

		// Vérifier si l'URL a un sous-domaine
		$subdomain = '';
		$hostParts = explode('.', $parsedUrl['host']);
		if (count($hostParts) > 2) {
			$subdomain = $hostParts[0];
		}

		// Vérifier le TLD (Top Level Domain)
		$tld = '';
		$validTlds = array(
			'com' => 'Commercial',
			'org' => 'Organization',
			'net' => 'Network',
			'gov' => 'Government',
			'edu' => 'Education',
			'af' => 'Afghanistan' ,
			'ax' => 'Åland' ,
			'al' => 'Albanie' ,
			'dz' => 'Algérie' ,
			'as' => 'Samoa américaines' ,
			'ad' => 'Andorre' ,
			'ao' => 'Angola' ,
			'ai' => 'Anguilla' ,
			'aq' => 'Antarctique' ,
			'ag' => 'Antigua-et-Barbuda' ,
			'ar' => 'Argentine' ,
			'am' => 'Arménie' ,
			'aw' => 'Aruba' ,
			'au' => 'Australie' ,
			'at' => 'Autriche' ,
			'az' => 'Azerbaïdjan' ,
			'bs' => 'Bahamas' ,
			'bh' => 'Bahreïn' ,
			'bd' => 'Bangladesh' ,
			'bb' => 'Barbade' ,
			'by' => 'Biélorussie' ,
			'be' => 'Belgique' ,
			'bz' => 'Belize' ,
			'bj' => 'Bénin' ,
			'bm' => 'Bermudes' ,
			'bt' => 'Bhoutan' ,
			'bo' => 'Bolivie' ,
			'ba' => 'Bosnie-Herzégovine' ,
			'bw' => 'Botswana' ,
			'bv' => 'Île Bouvet' ,
			'br' => 'Brésil' ,
			'io' => 'Territoire britannique de l\'océan Indien' ,
			'bn' => 'Brunéi' ,
			'bg' => 'Bulgarie' ,
			'bf' => 'Burkina Faso' ,
			'bi' => 'Burundi' ,
			'kh' => 'Cambodge' ,
			'cm' => 'Cameroun' ,
			'ca' => 'Canada' ,
			'cv' => 'Cap-Vert' ,
			'ky' => 'Îles Caïmans' ,
			'cf' => 'République centrafricaine' ,
			'td' => 'Tchad' ,
			'cl' => 'Chili' ,
			'cn' => 'Chine' ,
			'cx' => 'Île Christmas' ,
			'cc' => 'Îles Cocos' ,
			'co' => 'Colombie' ,
			'km' => 'Comores' ,
			'cg' => 'République du Congo' ,
			'cd' => 'République démocratique du Congo' ,
			'ck' => 'Îles Cook' ,
			'cr' => 'Costa Rica' ,
			'ci' => 'Côte d\'Ivoire' ,
			'hr' => 'Croatie' ,
			'cu' => 'Cuba' ,
			'cy' => 'Chypre' ,
			'cz' => 'République tchèque' ,
			'dk' => 'Danemark' ,
			'dj' => 'Djibouti' ,
			'dm' => 'Dominique' ,
			'do' => 'République dominicaine' ,
			'ec' => 'Équateur' ,
			'eg' => 'Égypte' ,
			'sv' => 'Salvador' ,
			'gq' => 'Guinée équatoriale' ,
			'er' => 'Érythrée' ,
			'ee' => 'Estonie' ,
			'et' => 'Éthiopie' ,
			'fk' => 'Îles Falkland' ,
			'fo' => 'Îles Féroé' ,
			'fj' => 'Fidji' ,
			'fi' => 'Finlande' ,
			'fr' => 'France' ,
			'gf' => 'Guyane française' ,
			'pf' => 'Polynésie française' ,
			'tf' => 'Terres australes françaises' ,
			'ga' => 'Gabon' ,
			'gm' => 'Gambie' ,
			'ge' => 'Géorgie' ,
			'de' => 'Allemagne' ,
			'gh' => 'Ghana' ,
			'gi' => 'Gibraltar' ,
			'gr' => 'Grèce' ,
			'gl' => 'Groenland' ,
			'gd' => 'Grenade' ,
			'gp' => 'Guadeloupe' ,
			'gu' => 'Guam' ,
			'gt' => 'Guatemala' ,
			'gg' => 'Guernesey' ,
			'gn' => 'Guinée' ,
			'gw' => 'Guinée-Bissau' ,
			'gy' => 'Guyana' ,
			'ht' => 'Haïti' ,
			'hm' => 'Îles Heard et McDonald' ,
			'va' => 'Saint-Siège' ,
			'hn' => 'Honduras' ,
			'hk' => 'Hong Kong' ,
			'hu' => 'Hongrie' ,
			'is' => 'Islande' ,
			'in' => 'Inde' ,
			'id' => 'Indonésie' ,
			'ir' => 'Iran' ,
			'iq' => 'Irak' ,
			'ie' => 'Irlande' ,
			'im' => 'Île de Man' ,
			'il' => 'Israël' ,
			'it' => 'Italie' ,
			'jm' => 'Jamaïque' ,
			'jp' => 'Japon' ,
			'je' => 'Jersey' ,
			'jo' => 'Jordanie' ,
			'kz' => 'Kazakhstan' ,
			'ke' => 'Kenya' ,
			'ki' => 'Kiribati' ,
			'kp' => 'Corée du Nord' ,
			'kr' => 'Corée du Sud' ,
			'kw' => 'Koweït' ,
			'kg' => 'Kirghizistan' ,
			'la' => 'Laos' ,
			'lv' => 'Lettonie' ,
			'lb' => 'Liban' ,
			'ls' => 'Lesotho' ,
			'lr' => 'Libéria' ,
			'ly' => 'Libye' ,
			'li' => 'Liechtenstein' ,
			'lt' => 'Lituanie' ,
			'lu' => 'Luxembourg' ,
			'mo' => 'Macao' ,
			'mk' => 'Macédoine du Nord' ,
			'mg' => 'Madagascar' ,
			'mw' => 'Malawi' ,
			'my' => 'Malaisie' ,
			'mv' => 'Maldives' ,
			'ml' => 'Mali' ,
			'mt' => 'Malte' ,
			'mh' => 'Îles Marshall' ,
			'mq' => 'Martinique' ,
			'mr' => 'Mauritanie' ,
			'mu' => 'Maurice' ,
			'yt' => 'Mayotte' ,
			'mx' => 'Mexique' ,
			'fm' => 'Micronésie' ,
			'md' => 'Moldavie' ,
			'mc' => 'Monaco' ,
			'mn' => 'Mongolie' ,
			'me' => 'Monténégro' ,
			'ms' => 'Montserrat' ,
			'ma' => 'Maroc' ,
			'mz' => 'Mozambique' ,
			'mm' => 'Myanmar' ,
			'na' => 'Namibie' ,
			'nr' => 'Nauru' ,
			'np' => 'Népal' ,
			'nl' => 'Pays-Bas' ,
			'nc' => 'Nouvelle-Calédonie' ,
			'nz' => 'Nouvelle-Zélande' ,
			'ni' => 'Nicaragua' ,
			'ne' => 'Niger' ,
			'ng' => 'Nigéria' ,
			'nu' => 'Niue' ,
			'nf' => 'Île Norfolk' ,
			'mp' => 'Îles Mariannes du Nord' ,
			'no' => 'Norvège' ,
			'om' => 'Oman' ,
			'pk' => 'Pakistan' ,
			'pw' => 'Palaos' ,
			'ps' => 'Palestine' ,
			'pa' => 'Panama' ,
			'pg' => 'Papouasie-Nouvelle-Guinée' ,
			'py' => 'Paraguay' ,
			'pe' => 'Pérou' ,
			'ph' => 'Philippines' ,
			'pn' => 'Pitcairn' ,
			'pl' => 'Pologne' ,
			'pt' => 'Portugal' ,
			'pr' => 'Porto Rico' ,
			'qa' => 'Qatar' ,
			're' => 'Réunion' ,
			'ro' => 'Roumanie' ,
			'ru' => 'Russie' ,
			'rw' => 'Rwanda' ,
			'bl' => 'Saint-Barthélemy' ,
			'sh' => 'Sainte-Hélène' ,
			'kn' => 'Saint-Kitts-et-Nevis' ,
			'lc' => 'Sainte-Lucie' ,
			'mf' => 'Saint-Martin' ,
			'pm' => 'Saint-Pierre-et-Miquelon' ,
			'vc' => 'Saint-Vincent-et-les-Grenadines' ,
			'ws' => 'Samoa' ,
			'sm' => 'Saint-Marin' ,
			'st' => 'Sao Tomé-et-Principe' ,
			'sa' => 'Arabie saoudite' ,
			'sn' => 'Sénégal' ,
			'rs' => 'Serbie' ,
			'sc' => 'Seychelles' ,
			'sl' => 'Sierra Leone' ,
			'sg' => 'Singapour' ,
			'sx' => 'Saint-Martin (partie néerlandaise)' ,
			'sk' => 'Slovaquie' ,
			'si' => 'Slovénie' ,
			'sb' => 'Îles Salomon' ,
			'so' => 'Somalie' ,
			'za' => 'Afrique du Sud' ,
			'gs' => 'Géorgie du Sud-et-les îles Sandwich du Sud' ,
			'ss' => 'Soudan du Sud' ,
			'es' => 'Espagne' ,
			'lk' => 'Sri Lanka' ,
			'sd' => 'Soudan' ,
			'sr' => 'Suriname' ,
			'sj' => 'Svalbard et Jan Mayen' ,
			'se' => 'Suède' ,
			'ch' => 'Suisse' ,
			'sy' => 'Syrie' ,
			'tw' => 'Taïwan' ,
			'tj' => 'Tadjikistan' ,
			'tz' => 'Tanzanie' ,
			'th' => 'Thaïlande' ,
			'tl' => 'Timor-Leste' ,
			'tg' => 'Togo' ,
			'tk' => 'Tokelau' ,
			'to' => 'Tonga' ,
			'tt' => 'Trinité-et-Tobago' ,
			'tn' => 'Tunisie' ,
			'tr' => 'Turquie' ,
			'tm' => 'Turkménistan' ,
			'tc' => 'Îles Turques-et-Caïques' ,
			'tv' => 'Tuvalu' ,
			'ug' => 'Ouganda' ,
			'ua' => 'Ukraine' ,
			'ae' => 'Émirats arabes unis' ,
			'uk' => 'Royaume-Uni' ,
			'us' => 'États-Unis' ,
			'um' => 'Îles mineures éloignées des États-Unis' ,
			'uy' => 'Uruguay' ,
			'uz' => 'Ouzbékistan' ,
			'vu' => 'Vanuatu' ,
			've' => 'Venezuela' ,
			'vn' => 'Vietnam' ,
			'vg' => 'Îles Vierges britanniques' ,
			'vi' => 'Îles Vierges des États-Unis' ,
			'wf' => 'Wallis-et-Futuna' ,
			'eh' => 'Sahara occidental' ,
			'ye' => 'Yémen' ,
			'zm' => 'Zambie' ,
			'zw' => 'Zimbabwe' ,



		);

		// Extraire le domaine et le TLD
		$domainParts = explode('.', $parsedUrl['host']);
		$domain = '';
		if (count($domainParts) >= 2) {
			$domain = $domainParts[count($domainParts) - 2];
			$tld = $domainParts[count($domainParts) - 1];

			// Vérifier si le TLD est associé à une valeur personnalisée
			if (array_key_exists($tld, $validTlds)) {
				$tld = $validTlds[$tld];
			}
		}

		// Résultat sous forme de tableau associatif
		$result = array(
			'protocol' => $protocol,
			'host' => $parsedUrl['host'],
			'subdomain' => $subdomain,
			'domain' => $domain,
			'tld' => $tld,
			'ip' => $ip
		);

		return $result;
	}
	

	/**
	 * Obtient l'adresse IP associée à une URL donnée en utilisant dns_get_record.
	 *
	 * @param string $url L'URL pour laquelle obtenir l'adresse IP.
	 * @return string|array Un message d'erreur ou l'adresse IP associée à l'URL.
	 */
	function getIpFromUrl($url): string {
		if (substr($url, -1) == '/') {
			$url = substr($url, 0, -1);
		}
		
		$urlComponents = parse_url($url);
		
		if ($urlComponents === false) {
			return "URL invalide";
		}
		
		$dns_records = dns_get_record($urlComponents['host'], DNS_A);
		
		if (!empty($dns_records) && isset($dns_records[0]['ip'])) {
			$ip = $dns_records[0]['ip'];
			return $ip;
		} else {
			return "Aucun enregistrement DNS trouvé";
		}
	}
	
	/**
	 * Convertit une valeur octale en représentation RWX (lecture, écriture, exécution).
	 *
	 * @param string $octalValue La valeur octale à convertir (ex. '755').
	 * @return string|bool La représentation RWX correspondante ou un message d'erreur si la valeur octale est invalide.
	 */
	function octalToRwx($octalValue): string {
			// Vérifier que la valeur octale est valide
			if (!preg_match('/^[0-7]{3}$/', $octalValue)) {
				return "Valeur octale invalide.";
			}

			// Tableau des combinaisons de droits
			$permissions = array(
				'---', '--x', '-w-', '-wx', 'r--', 'r-x', 'rw-', 'rwx'
			);

			// Séparer les chiffres de l'octal
			$owner = $octalValue[0];
			$group = $octalValue[1];
			$others = $octalValue[2];

			// Convertir chaque chiffre en droits correspondants
			$ownerPermissions = $permissions[$owner];
			$groupPermissions = $permissions[$group];
			$othersPermissions = $permissions[$others];

			// Retourner la chaîne formatée
			return "$ownerPermissions $groupPermissions $othersPermissions";
	}
	
	/**
	 * Redirige l'utilisateur vers le moteur de recherche choisi avec la requête de recherche.
	 *
	 * @param string $searchQuery La requête de recherche à effectuer.
	 * @param string $searchEngine Le moteur de recherche choisi (google, bing, yahoo).
	 * 
	 * @return void
	 */
	function redirectSearch($searchQuery, $searchEngine) {
		$searchQuery = urlencode($searchQuery);

		switch ($searchEngine) {
			case 'google':
				header("Location: https://www.google.com/search?q=$searchQuery");
				break;
			case 'bing':
				header("Location: https://www.bing.com/search?q=$searchQuery");
				break;
			case 'yahoo':
				header("Location: https://search.yahoo.com/search?p=$searchQuery");
				break;
			default:
				echo "Moteur de recherche non pris en charge.";
				break;
		}

		exit(); // Assurez-vous de terminer le script après la redirection.
	}
	
	/**
	 * Calculate the octal value for chmod based on the provided permissions.
	 *
	 * This function takes the input from a form that represents file permissions for
	 * user, group, and others. It calculates and returns the corresponding octal
	 * value for the chmod command.
	 *
	 * @return int The calculated octal value for chmod.
	 */
	function calculateChmodOctal() : int {
		// Initialize the chmod value to 0
		$chmodValue = 0;

		// User permissions
		$chmodValue += isset($_POST['ur']) ? 4 : 0; // Read
		$chmodValue += isset($_POST['uw']) ? 2 : 0; // Write
		$chmodValue += isset($_POST['ux']) ? 1 : 0; // Execute

		// Group permissions
		$chmodValue *= 10; // Shift to the left by one digit
		$chmodValue += isset($_POST['gr']) ? 4 : 0; // Read
		$chmodValue += isset($_POST['gw']) ? 2 : 0; // Write
		$chmodValue += isset($_POST['gx']) ? 1 : 0; // Execute

		// Others permissions
		$chmodValue *= 10; // Shift to the left by one digit
		$chmodValue += isset($_POST['or']) ? 4 : 0; // Read
		$chmodValue += isset($_POST['ow']) ? 2 : 0; // Write
		$chmodValue += isset($_POST['ox']) ? 1 : 0; // Execute

		// Return the calculated chmod value
		return $chmodValue;
	}
	
	/**
	 * Vérifie si une année est bissextile.
	 *
	 * @param int $annee L'année à vérifier.
	 * @return bool True si l'année est bissextile, sinon False.
	 */
	function estBissextile($annee) : bool  {
		return (($annee % 4 == 0 && $annee % 100 != 0) || ($annee % 400 == 0));
	}

	/**
	 * Traite les données du formulaire et affiche le résultat.
	 *
	 * @return string
	 */
	function bissextile() : string {
		if (isset($_POST['annee'])) {
			$annee = $_POST['annee'];

			// Vérifier si l'année est bissextile
			$estBissextile = estBissextile($annee);

			// Récupérer le jour de la semaine du 1er janvier
			$jourSemaine = date("l", strtotime("$annee-01-01"));

			// Afficher le résultat
			return "L'année $annee " . ($estBissextile ? "est" : "n'est pas") . " bissextile. Le 1er janvier est un $jourSemaine.";
		}
	}

	// cette fonction est aussi au sein d'un fichier util mais dans le doute j'ai préférer mettre le code ici aussi
	/**
	 * Retourne le nom du navigateur de l'internaute.
	 *
	 * @return string Le nom du navigateur.
	 */
	/*function get_navigateur() {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];

		if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
			return 'Internet Explorer';
		} elseif (strpos($userAgent, 'Edge') !== false) {
			return 'Microsoft Edge';
		} elseif (strpos($userAgent, 'Firefox') !== false) {
			return 'Mozilla Firefox';
		} elseif (strpos($userAgent, 'Chrome') !== false) {
			return 'Google Chrome';
		} elseif (strpos($userAgent, 'Safari') !== false) {
			return 'Safari';
		} elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
			return 'Opera';
		} else {
			return 'Navigateur inconnu';
		}
	}*/

?>