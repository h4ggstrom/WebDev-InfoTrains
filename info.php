<?php 
/**
 * page d'affichage des information d'une gare.
 * @file info.php
 * @brief page d'affichage des information d'une gare spécifique.
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr> 
 */
	$title = "GareSeeker-Infos-Gare";
	$h1 = "Infos Gare";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
	$datalist = getDatalist('search');
	$infosGare = rechercheInfoGare();
?>

<main>
	<article>
		<div class="centered-form" >
			<form method="GET" class="search-form">
				<input list="search" id="gare" name="search" placeholder="Rechercher" class="search-box"/>
				<button type="submit">Rechercher</button>
				<?=$datalist?> 

			</form>
		</div>

		<?=$infosGare?>
	</article>
</main>

<?php

	require "include/footer.inc.php";

?>