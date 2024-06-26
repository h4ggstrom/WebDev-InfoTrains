<?php 
/**
 * page d'affichage des informations pour une gare donnée.
 * 
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr> 
 */
	$title = "Infos Gare";
	$h1 = "Infos Gare";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
	$datalist = getDatalist('search');
	$infosGare = rechercheInfoGare();
?>

    <form method="GET">
		<input type="submit" value="Go">
        <input list="search" id="gare" name="search" placeholder="Rechercher">
		<?=$datalist?> 

    </form>

    <?=$infosGare?>

<?php

	require "include/footer.inc.php";

?>