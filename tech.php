<?php 
	declare(strict_types=1);
	$title = "UJR Acceuil";
	$h1 = "tech";
	require_once "include/fonctions.inc.php";
	require "include/header.inc.php";
	require_once "include/util.php";
	$navigateur = get_navigateur();
?>
<main>
<section>
        <h2>Page technique des API</h2>
        <article>
            <h3>Astronomy Picture of The Day - Developer Page</h3>
            <?php echo fetchAPOD(); ?>
        </article>

        <article>
            <h3>Localisation par adresse IP avec ipinfo.io</h3>
            <?php echo fetchIpInfoLocation(); ?>
        </article>

        <article>
            <h3>Localisation par adresse IP avec GeoPlugin (JSON)</h3>
            <?php echo fetchGeoPluginLocationJson(); ?>
        </article>

        <article>
            <h3>Localisation par adresse IP avec GeoPlugin (XML)</h3>
            <?php echo fetchGeoPluginLocationXml(); ?>
        </article>

        <article>
            <h3>Localisation par adresse IP avec GeoPlugin (CSV)</h3>
            <?php echo getGeoPluginLocationCsvCode(); ?>
        </article>
    </section>
</main>

<?php

	require "include/footer.inc.php";

?>