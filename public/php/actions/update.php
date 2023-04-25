<?php
/**
 * Action à réaliser lors de <code>update</code>: affiche le formulaire pour update une photo dans la base de données.
 * @author Joris MASSON
 * @package actions
 * @uses Photo
 */

use classes\Photo;

$idP = key_exists('idP', $_GET) ? $_GET['idP'] : null;

if (!is_numeric($_GET["idP"])) {
    $body = "<h2 class='error'>Erreur, idP incorrect.</h2>";
} else {
    $body = "<h1>Mise à jour de la photo $idP</h1>";
    if (!isset($_FILES["photo"]) && file_exists("public/images/temp/$idP.png")) {
        unlink("public/images/temp/$idP.png"); // vide le temp
    }
    if (!isset($_POST["author"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"])) {
        $data_photo = Photo::fetch_all_values($idP);

        $author = $data_photo["author"];
        $title = $data_photo["title"];
        $dateP = $data_photo["dateP"];
        $descriptionP = $data_photo["descriptionP"];
        include_once("public/php/pages/formulaire_update.php");
    } else {
        /* Attribution des variables */
        $author = trim($_POST['author']);
        $title = !empty($_POST["title"]) ? $_POST['title'] : "Sans titre";
        $descriptionP = trim($_POST['descriptionP']);
        $dateP = trim($_POST['dateP']);

        $errors = check_errors_update($author, $descriptionP, $dateP);

        if (count_errors($errors) == 0) {
            if (isset($_FILES["photo"])) {
                var_dump($_FILES);
                $file = $_FILES["photo"];
                move_uploaded_file($file["tmp_name"], "public/images/temp/$idP.png");
            }
            $body = <<<HTML
            <form action='index.php?action=confirm' method='post'>
            <input type='hidden' name='type' value='confirmupdate'/>
            <input type='hidden' name='idP' value='$idP'/>
            <input type='hidden' name='author' value='$author'/>
            <input type='hidden' name='title' value='$title'/>
            <input type='hidden' name='descriptionP' value='$descriptionP'/>
            <input type='hidden' name='dateP' value='$dateP'/>
            Etes vous sûr de vouloir mettre à jour cette photo ?
            <p><input class="confirm-button" type='submit' value='Mettre à jour'><a href='index.php?action=list'>Annuler</a></p>
            </form>
            HTML;
        } else {
            include_once("public/php/pages/formulaire_update.php");
        }
    }
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
function check_errors_update(string $author, string $descriptionP, string $dateP): array
{
    $errors = array("author" => null, "descriptionP" => null, "dateP" => null);
    if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
    if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
    if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";

    return $errors;
}
