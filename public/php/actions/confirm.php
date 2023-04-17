<?php
/**
 * Action à réaliser lors de <code>confirm</code>: update ou supprime une photo de la base de données.
 *
 * L'action à réaliser est décidée grâce à une valeur transmise via POST: <code>type</code>:
 *
 * -<code>confirmupdate</code> -> update une photo.
 *
 * -<code>confirmdelete</code> -> supprime une photo.
 * @author Joris MASSON
 * @package actions
 * @uses Photo
 */

use classes\Photo;

/* récupère les valeurs de la requête POST */
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

/**
 * Check les erreurs venant des input du formulaire, pour l'action <code>confirm</code>.
 *
 * Plus précisément pour <code>confirmupdate</delete>.
 * @param string $author Valeur pour <code>author</code>
 * @param string $descriptionP Valeur pour <code>descriptionP</code>
 * @param string $dateP Valeur pour <code>dateP</code>
 * @return array La liste des erreurs reconnues.
 */
function check_errors_confirm(string $author, string $descriptionP, string $dateP): array
{
    $errors = array("author" => null, "descriptionP" => null, "dateP" => null);
    if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
    if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
    if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";

    return $errors;
}