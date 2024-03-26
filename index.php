<?php 
	declare(strict_types=1);
	$title = "UJR Acceuil";
	$h1 = "projet php";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>

<aside>
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
        <figure>
            <img src="<?php echo $imageAleatoire; ?>" alt="Image aléatoire"/>
            <figcaption>Nom de l'image : <?php echo $imageAleatoire; ?></figcaption>
        </figure>
</aside>
<main>


</main>

<?php

	require "include/footer.inc.php";

?>
