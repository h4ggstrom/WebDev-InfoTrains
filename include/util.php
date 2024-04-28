<?php
/**
 * fichier contenant des fonctions du site.
 * @file util.php
 * @brief fichier contenant des fonctions util au site.
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr> 
 */

/**
 * Retourne le nom du navigateur de l'internaute.
 *
 * @version 1.0
 * @author Robin de Angelis <robin.de-angelis@etu.cyu.fr>
 * @author Louis Gallet <louis.gallet@etu.cyu.fr>
 * @return string Le nom du navigateur.
 */
function get_navigateur() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
        return 'Internet Explorer';
    } elseif (strpos($userAgent, 'Edge') !== false) {
        return 'Microsoft Edge';
    } elseif (strpos($userAgent, 'Firefox') !== false) {
        return 'Mozilla Firefox';
    } elseif (strpos($userAgent, 'Chrome') !== false) {
        return 'Google Chrome';
    } elseif (strpos($userAgent, 'Safari') !== false) {
        return 'Safari';
    } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
        return 'Opera';
    } else {
        return 'Navigateur inconnu';
    }
}
?>
