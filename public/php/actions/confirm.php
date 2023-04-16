<?php
use classes\Photo;
// TODO Gérer avec la classe Photo

$connection = connecter();
$idP = key_exists('idP', $_POST)? $_POST['idP']: null;
$type = key_exists('type', $_POST)? $_POST['type']: null;
if ($type =='confirmupdate') {
    $body = "<h1>Mise à jour de la photo $idP</h1>";
    if (!isset($_POST["author"]) && !isset($_POST["title"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"])) {
        include_once("public/php/pages/formulaire_update.php");
    } else {
        /* Attribution des variables */
        $author = trim($_POST['author']);
        $title = key_exists('title', $_POST) ? $_POST['title'] : "Sans titre";
        $descriptionP = trim($_POST['descriptionP']);
        $dateP = trim($_POST['dateP']);

        /* Check des erreurs */
        if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
        // le titre est optionnel
        if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
        if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";

        if (count_errors($errors) == 0) {
            $prep_req = $connection->prepare("UPDATE Photo SET author=:author, title=:title, descriptionP=:descriptionP, dateP=:dateP WHERE idP=:idP");
            $prep_req->execute(array(
                ":author" => $author,
                ":title" => $title,
                ":descriptionP" => $descriptionP,
                ":dateP" => $dateP,
                ":idP" => $idP
            ));

            /* vérifie si une nouvelle image a été envoyée */
            if (isset($_FILES["photo"])) {
                $photo = $_FILES["photo"];
                move_uploaded_file($photo["tmp_name"], "public/images/photos/" . $idP . ".png");
            }
            $body .= "<h2>Photo mise à jour!</h2>";
        } else {
            include_once("public/php/pages/formulaire_update.php");
        }
    }
}
else {
    Photo::delete_from_database($idP);
    $body = "<h2>Photo $idP supprimée!</h2>" ;
}
$connection = null;
