<?php 
/**
 * page d'affichage des stats de recherches des utilisateurs.
 * @file stats.php
 * @brief page d'affichage des statistique de notre site
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr> 
 */
	$title = "GareSeeker-Statistiques";
	$h1 = "Statistiques";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
    $graph = getGraph();
?>
<main>
	<article>
		<?=$graph?>
		<h2>Que sont ces chiffres ?</h2>
		<p>
			Ce tableau représente le classement général (et donc commun à tous les utilisateurs) des gares les plus recherchées sur ce site.
			Ces statistiques prennent en compte les recherches des départs, ainsi que les recheches d'informations sur une gare. En revanche, elles ne prennent pas en compte la restauration
			de la dernière gare consultée quand une nouvelle visite est effectuée sur le site. Pas d'inquiétude à avoir concernant la collecte de données. les statistiques sont anonymes, et
			stockées uniquement sur ce site, et nul part ailleurs.
		</p>
	</article>
</main>
<?php
    require "include/footer.inc.php";
?>