<?php
  declare(strict_types=1);
  $title = "UJR Acceuil";
  $h1 = "projet php";
  require_once "include/fonctions.inc.php";
  require "include/header.inc.php";
  require_once "include/util.php";
  $navigateur = get_navigateur();
  if (isset($_GET['q'])) { 
    $affgare = $_GET['q'];
   } else {
    $affgare = "Entrez un nom de gare pour commencer";
  };
  $departs = lastDepartureSearch();
  $datalist = getDatalist();
?>

<main>

  <form method="get">
    <input list="search" placeholder="Entrer un nom de gare" name="q">
    <?$datalist?>
    <button type="submit">Rechercher</button>
  </form>

  <h1><?=$affgare?></h1>
    <?=$departs?>
</main>

<?php

	require "include/footer.inc.php";

?>