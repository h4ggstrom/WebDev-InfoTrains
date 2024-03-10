		<article>
			<h3>Choix de la langue</h3>
			<a href="?lang=fr&amp;style=<?php echo $Style; ?>">
				<img src="image/francais.jpg" alt="francais" class="lang" />
			</a>
			<a href="?lang=en&amp;style=<?php echo $Style; ?>">
				<img src="image/anglais.jpg" alt="english" class="lang" />
			</a>
		</article>
		
		<article>
			<h3>Entrez une URL :</h3>
				
			<form method="post">
				<label for="url">URL :</label>
				<input type="text" name="url" id="url" required="required"/>
				<button type="submit">Extraire</button>
			</form>

			<?php
			// Vérifier si le formulaire a été soumis
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Récupérer l'URL depuis le formulaire
				$url = $_POST['url'];

				// Appeler la fonction pour extraire les informations
				$resultat = extraireInformationsURL($url);

				// Afficher les résultats dans un tableau HTML
				echo '<h2>Résultats :</h2>';
				echo "<table class=\"td8\">\n";
				foreach ($resultat as $key => $value) {
					echo "<tr>\n";
					echo '<th>' . htmlspecialchars($key) . "</th>\n";
					echo '<td>' . htmlspecialchars($value) . "</td>\n";
					echo "</tr>\n";
				}
				echo "</table>\n";
			}
			?>
		</article>
		
		<article>
			<h3>Exercice 2</h3>
			<?php
				// Récupérer la valeur octale depuis l'URL
				$octalFromURL = isset($_GET['octal']) ? $_GET['octal'] : '';

				// Utiliser la fonction avec la valeur octale spécifiée
				$result = octalToRwx($octalFromURL);

				// Afficher le résultat
				echo "<p>Valeur octale : $octalFromURL</p>";
				echo "<p>Droits correspondants : $result</p>\n";
			?>
			
			<p>Appuyez sur 'Tester' pour essayer</p>
			<a href="?octal=751">tester</a>
		
		</article>
		
		<article>
			<h3>tableau</h3>
			
			<?php
			
				$size = isset($_GET['size']) ? intval($_GET['size']) : 10;

				// Appeler la fonction avec la taille spécifiée
				echo multiplicationTable($size,$size);
			
			?>
			
			<p>Appuyez sur 'Tester' pour essayer</p>
			<a href="?size=12" >tester</a>
		
		</article>