<?php
/**
 * Gère le choix du thème (mode jour/nuit) sur le site web.
 *
 * Cette fonction utilise des cookies pour mémoriser la préférence de l'utilisateur
 * et inclut également le fichier CSS correspondant au thème sélectionné.
 *
 * @return string Le mode actuel sélectionné ('jour' ou 'nuit').
 */
function gestionTheme() {
    // Vérification si le mode a été choisi
    if(isset($_GET['mode'])) {
        // Mode nuit choisi
        if($_GET['mode'] === 'nuit') {
            // Définition du cookie pour le mode nuit
            setcookie('mode', 'nuit', time() + (86400 * 30), "/");
            return 'nuit';
        }
        // Mode jour choisi
        else if($_GET['mode'] === 'jour') {
            // Définition du cookie pour le mode jour
            setcookie('mode', 'jour', time() + (86400 * 30), "/");
            return 'jour';
        }
    }

    // Vérification si le cookie existe
    if(isset($_COOKIE['mode'])) {
        // Vérification de la valeur du cookie pour déterminer le mode actuel
        return ($_COOKIE['mode'] === 'nuit') ? 'nuit' : 'jour';
    }

    // Mode par défaut : jour
    return 'jour';
}

// Appel de la fonction pour gérer le choix de thème
$mode = gestionTheme();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page avec choix de la charte graphique</title>
    <!-- Inclusion du CSS selon le mode sélectionné -->
    <link rel="stylesheet" type="text/css" href="<?php echo ($mode === 'jour') ? 'css/styles.css' : 'css/styles_alternatif.css'; ?>">
</head>
<body>
    <header>
        <h1>Mon site</h1>
    </header>
    <nav>
        <!-- Liens pour choisir le mode -->
        <a href="?mode=jour"><img src="icone_jour.png" alt="Mode jour"></a>
        <a href="?mode=nuit"><img src="icone_nuit.png" alt="Mode nuit"></a>
    </nav>
    <main>
        <!-- Contenu principal de la page -->
    </main>
    <footer>
        <!-- Pied de page -->
    </footer>
</body>
</html>