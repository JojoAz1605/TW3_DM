<?php
// TODO ramener un peu du confirm ici(tout ce qui est en rapport avec l'affichage/gestion du formulaire)

/**
 * Action à réaliser lors de <code>update</code>: affiche le formulaire pour update une photo dans la base de données.
 * @author Joris MASSON
 * @package actions
 * @uses Photo
 */

use classes\Photo;

$idP = key_exists('idP', $_GET) ? $_GET['idP'] : null;

$data_photo = Photo::fetch_all_values($idP);

$author = $data_photo["author"];
$title = $data_photo["title"];
$dateP = $data_photo["dateP"];
$descriptionP = $data_photo["descriptionP"];

$body = "<h1>Mise à jour de la photo $idP</h1>";
include_once("public/php/pages/formulaire_update.php");
