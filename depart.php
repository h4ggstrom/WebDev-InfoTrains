<?php
  declare(strict_types=1);
  $title = "UJR Acceuil";
  $h1 = "projet php";
  require_once "include/fonctions.inc.php";
  require "include/header.inc.php";
  require_once "include/util.php";
  $navigateur = get_navigateur();
  $affGare = lastDepartureName();
?>

<main>

  <form method="get" action="./depart.php">
    <input list="search" placeholder="Entrer un nom de gare" name="q">
    <?php echo getDatalist()?>
    <button type="submit">Rechercher</button>
  </form>

  <h1><?=$affGare;?></h1>
    <?php
      echo lastDepartureSearch();
    ?>
</main>

<?php

	require "include/footer.inc.php";

?>