<?php

use classes\Photo;

$idP = key_exists('idP', $_POST) ? $_POST['idP'] : null;
$type = key_exists('type', $_POST) ? $_POST['type'] : null;

if ($type == 'confirmupdate') {
    $body = "<h1>Mise à jour de la photo $idP</h1>";
    if (!isset($_POST["author"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"])) {
        include_once("public/php/pages/formulaire_update.php");
    } else {
        /* Attribution des variables */
        $author = trim($_POST['author']);
        $title = key_exists('title', $_POST) ? $_POST['title'] : "Sans titre";
        $descriptionP = trim($_POST['descriptionP']);
        $dateP = trim($_POST['dateP']);

        $errors = check_errors_confirm($author, $title, $descriptionP);

        if (count_errors($errors) == 0) {
            $photo = new Photo($author, $title, $descriptionP, $dateP, $idP);
            $photo->update_in_database();
            $body .= "<h2>Photo mise à jour!</h2>";
        } else {
            include_once("public/php/pages/formulaire_update.php");
        }
    }
} else if ($type == "confirmdelete") {
    Photo::delete_from_database($idP);
    $body = "<h2>Photo $idP supprimée!</h2>";
}

function check_errors_confirm($author, $descriptionP, $dateP): array
{
    $errors = array("author" => null, "descriptionP" => null, "dateP" => null);
    if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
    if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
    if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";

    return $errors;
}