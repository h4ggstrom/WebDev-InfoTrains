<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8"/>
	<meta name="louis gallet" content="width=device-width, initial-scale=1.0"/>
	<?php
    // Changement de style en fonction du paramètre 'style'
    if (isset($_GET['style']) && $_GET['style'] === 'alternatif') {
        echo '<link rel="stylesheet" href="css/styles_alternatif.css"/>';
		$Style="alternatif";
    }else{
		echo '<link rel="stylesheet" href="css/styles.css" id="main-style"/>';
		$Style="standard";
	}
    ?>
	<link rel="icon" type="image/x-icon" href="image/ouroboros.png"/>
	<title><?php echo $title ?></title>
</head>
<body>

	<header>
		<h1><?php echo $h1 ?></h1>
		<a href="?style=standard" class = "lien-bouton">Style Clair</a>
        <a href="?style=alternatif" class = "lien-bouton">Style Sombre</a>
		<nav>
			<ul>
				<li><a href="<?php echo "index.php?style=" . $Style; ?>">Accueil</a></li>
				<li><a href="<?php echo "td5.php?style=" . $Style; ?>">TD5</a></li>
				<li><a href="<?php echo "td6.php?style=" . $Style; ?>">TD6</a></li>
				<li><a href="<?php echo "td7.php?style=" . $Style; ?>">TD7</a></li>
				<li><a href="<?php echo "td8.php?style=" . $Style; ?>">TD8</a></li>
				<li><a href="<?php echo "td9.php?style=" . $Style; ?>">TD9</a></li>
			</ul>
		</nav>
		<figure>
			<img src="image/logo.png" alt="Logo du site" class="logo"/>
			<figcaption></figcaption>
		</figure>
	</header>