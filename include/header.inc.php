<?php
/**
 * fichier contenant le header du site.
 * @file header.inc.php
 * @brief fichier contenant le header du site.
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr> 
 */
?> 
<?php $mode = gestionTheme("/projet/"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="<?php echo ($mode === 'jour') ? 'css/styles.css' : 'css/styles_alternatif.css'; ?>"/>
	<link rel="icon" type="image/x-icon" href="image/train.ico"/>
	<title><?php echo $title ?></title>
</head>
<body>

	<header>
		<h1><?php echo $h1 ?></h1>
		<a href="?mode=jour"><img src="image/mode_jour.png" alt="Image 1" class="img_theme"/></a>
        <a href="?mode=nuit"><img src="image/mode_nuit.png" alt="Image 2" class="img_theme"/></a>
		<nav>
			<ul>
				<li><a href="<?php echo "index.php" ?>"><span>Accueil</span></a></li>
				<li><a href="<?php echo "depart.php" ?>"><span>Départ</span></a></li>
				<li><a href="<?php echo "info.php" ?>"><span>Information gare</span></a></li>
				<li><a href="<?php echo "stats.php" ?>"><span>Statistiques</span></a></li>
			</ul>
		</nav>
		<figure>
			<img src="image/logo.png" alt="Logo du site" class="logo"/>
			<figcaption></figcaption>
		</figure>
	</header>