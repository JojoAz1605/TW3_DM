<?php
use classes\Photo;

$body = "<h2>Ajoutons une photo!</h2>";

/* montre le formulaire si les variables ne sont pas définies dans la requête POST */
if (!isset($_POST["author"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"]) && !isset($_FILES["photo"])) {
    include_once("public/php/pages/formulaire.php");
} else {
    $file = $_FILES["photo"];  // récupération de la photo

    $photo = new Photo(
        trim($_POST['author']),
        key_exists('title', $_POST)? $_POST['title']: "Sans titre",
        trim($_POST['descriptionP']),
        trim($_POST['dateP'])
    );

    $errors = check_errors_add($photo->get_author(), $photo->get_descriptionP(), $photo->get_dateP(), $file);

    if(count_errors($errors) == 0) {  // s'il n'y a pas d'erreurs
        $idP = $photo->insert_to_database();
        move_uploaded_file($file["tmp_name"], "public/images/photos/" . $idP . ".png");
        $body .= "<h2>Photo ajoutée!</h2>";
    } else {include_once("public/php/pages/formulaire.php"); }
}

function check_errors_add($author, $descriptionP, $dateP, $file): array {
    $errors = array("author" => null, "descriptionP" => null, "dateP" => null, "photo" => null);  // pour la gestion des erreurs de formulaire
    if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
    if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
    if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";
    if ($file["error"] == 4) $errors["photo"] = "Il manque le plus important: la photo!";  // code erreur 4 -> pas de fichier

    return $errors;
}
