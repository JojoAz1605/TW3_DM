<?php
/**
 * Action à réaliser lors de <code>detail</code>: affiche le détail d'une photo.
 * @author Joris MASSON
 * @package actions
 * @uses Photo
 */

use classes\Photo;

$idP = key_exists('idP', $_GET) ? $_GET['idP'] : null;

if (!is_numeric($_GET["idP"])) {
    $body = "<h2 class='error'>Erreur, idP incorrect.</h2>";
} else {
    $connection = connecter();

    $prep_req = $connection->prepare("SELECT * FROM Photo WHERE idP=:idP");
    $prep_req->execute(array(':idP' => $idP));
    $data_photo = $prep_req->fetch();

    $photo = new Photo($data_photo["author"], $data_photo["title"], $data_photo["descriptionP"], $data_photo["dateP"], $idP, $data_photo["dateS"]);

    $body = $photo->show_detail();  // demande le détail de la photo et l'affiche

    $query = null;
    $connection = null;
}
