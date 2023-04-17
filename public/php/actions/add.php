<?php
/**
 * Action à réaliser lors de <code>add</code>: ajoute une photo à la base de données.
 * @author Joris MASSON
 * @package actions
 * @uses Photo
 */

use classes\Photo;

$body = "<h2>Ajoutons une photo!</h2>";

/* montre le formulaire si les variables ne sont pas définies dans la requête POST */
if (!isset($_POST["author"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"]) && !isset($_FILES["photo"])) {
    include_once("public/php/pages/formulaire.php");
} else {
    $file = $_FILES["photo"];  // récupération de la photo

    $photo = new Photo(
        trim($_POST['author']),
        key_exists('title', $_POST) ? $_POST['title'] : "Sans titre",
        trim($_POST['descriptionP']),
        trim($_POST['dateP'])
    );

    $errors = check_errors_add($photo->get_author(), $photo->get_descriptionP(), $photo->get_dateP(), $file);

    if (count_errors($errors) == 0) {  // s'il n'y a pas d'erreurs
        $idP = $photo->insert_to_database();
        $body .= "<h2>Photo ajoutée!</h2>";
    } else {
        include_once("public/php/pages/formulaire.php");
    }
}

/**
 * Check les erreurs venant des input du formulaire, pour l'action <code>add</code>.
 * @param string $author Valeur pour <code>author</code>
 * @param string $descriptionP Valeur pour <code>descriptionP</code>
 * @param string $dateP Valeur pour <code>dateP</code>
 * @param array $file La photo
 * @return array La liste des erreurs reconnues.
 */
function check_errors_add(string $author, string $descriptionP, string $dateP, array $file): array
{
    $errors = array("author" => null, "descriptionP" => null, "dateP" => null, "photo" => null);  // pour la gestion des erreurs de formulaire
    if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
    if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
    if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";
    if ($file["error"] == 4) $errors["photo"] = "Il manque le plus important: la photo!";  // code erreur 4 -> pas de fichier

    return $errors;
}
