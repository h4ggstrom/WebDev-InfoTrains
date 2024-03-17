<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8"/>
	<meta name="louis gallet" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="<?php echo ($mode === 'jour') ? 'css/styles.css' : 'css/styles_alternatif.css'; ?>"/>
	<link rel="icon" type="image/x-icon" href="image/ouroboros.png"/>
	<title><?php echo $title ?></title>
</head>
<body>

	<header>
		<h1><?php echo $h1 ?></h1>
		<a href="?mode=jour" class = "lien-bouton">Style Clair</a>
        <a href="?mode=nuit" class = "lien-bouton">Style Sombre</a>
		<nav>
			<ul>
				<li><a href="<?php echo "index.php" ?>">Accueil</a></li>
			</ul>
		</nav>
		<figure>
			<img src="image/logo.png" alt="Logo du site" class="logo"/>
			<figcaption></figcaption>
		</figure>
	</header>