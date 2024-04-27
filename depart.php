<?php
/**
 * page d'affichage des départs pour une gare donnée.
 * 
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr> 
 */
  declare(strict_types=1);
  $title = "UJR Acceuil";
  $h1 = "projet php";
  require_once "include/fonctions.inc.php";
  require "include/header.inc.php";
  require_once "include/util.php";
  $navigateur = get_navigateur();
  $affgare = lastDepartureName();
  $departs = lastDepartureSearch();
  $datalist = getDatalist('search');
?>

<main>

  <form method="GET">
    <button type="submit">Rechercher</button>
    <input list="search" id="gare" name="q" placeholder="Entrer un nom de gare" >
    <?=$datalist?>

  </form>

  <h1><?=$affgare?></h1>
    <?=$departs?>
</main>

<?php

	require "include/footer.inc.php";

?>