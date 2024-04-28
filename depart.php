<?php
/**
 * page d'affichage des départs pour une gare donnée.
 * @file depart.php
 * @brief page d'affichage des départs pour une gare donnée.
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr>
 */
  declare(strict_types=1);
  $title = "GareSeeker-Départs";
  $h1 = "Départs";
  require_once "include/fonctions.inc.php";
  require "include/header.inc.php";
  require_once "include/util.php";
  $navigateur = get_navigateur();
  $affgare = lastDepartureName();
  $departs = lastDepartureSearch();
  $datalist = getDatalist('search');
?>

<main>
	<article>
		<div class="centered-form" >
			<form method="GET" class="search-form">
				<input list="search" id="gare" name="q" placeholder="Entrer un nom de gare" class="search-box"/>
				<button type="submit">Rechercher</button>
				<?=$datalist?>
			</form>
		</div>

		<h2><?=$affgare?></h2>
		<?=$departs?>
	</article>
		
</main>

<?php

	require "include/footer.inc.php";

?>