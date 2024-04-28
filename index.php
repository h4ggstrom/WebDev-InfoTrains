<?php 
/**
 * page d'acceuil de notre site.
 * @file index.php
 * @brief page d'acceuil de notre site web
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr>
 */
	declare(strict_types=1);
	$title = "GareSeeker-Acceuil";
	$h1 = "GareSeeker";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>

<main>
	<?php
    // Chemin du dossier contenant les images
    $dossier = "photos/";
        
    // Récupération de la liste des fichiers dans le dossier
    $fichiers = scandir($dossier);
        
    // Suppression des entrées . et ..
    $fichiers = array_diff($fichiers, array('..', '.'));
        
    // Sélection aléatoire d'une image
	$imageAleatoire = $dossier . $fichiers[array_rand($fichiers)];
    ?>
	
	<aside>
		<img src='<?php echo $imageAleatoire; ?>' alt="image aléatoire" class="special-img"/>
	</aside>
	
	<article>
		<h2>GareSeeker Options </h2>
		<section>
			<h3>Recherche de gares</h3>
			<p>Vous pouvez rechercher des informations sur une gare spécifique en utilisant notre fonction de recherche.</p>
			<a href="<?php echo "info.php" ?>"><span>cliquez ici pour y acceder</span></a>
		</section>

		<section>
			<h3>Départs futurs d'une gare</h3>
			<p>Vous pouvez également rechercher les départs futurs d'une gare spécifique en utilisant notre fonction de recherche des départs.</p>
			<a href="<?php echo "depart.php" ?>"><span>cliquez ici pour y acceder</span></a>
		</section>
	</article>
</main>

<?php

	require "include/footer.inc.php";

?>
