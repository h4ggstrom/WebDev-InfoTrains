
<?php 
	$title = "Infos Gare";
	$h1 = "Infos Gare";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>

    <form method="GET">
		<input type="submit" value="Zioum">
        <input list="search" id="gare" name="search" placeholder="Rechercher">
		<?php echo getDatalist()?> 

    </form>

    <?php echo rechercheInfoGare()?>

<?php

	require "include/footer.inc.php";

?>