
<?php 
	$title = "UJR Acceuil";
	$h1 = "projet php";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>

    <form method="GET">
        <label for="search">Rechercher :</label>
        <input type="text" id="search" name="search">
        <input type="submit" value="Rechercher">
    </form>

    <?php echo rechercheInfoGare()?>
</main>

<?php

	require "include/footer.inc.php";

?>