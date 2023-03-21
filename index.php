<?php
require_once("public/php/utils.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;

switch ($action) {
    case "add":
        $body = "<h2>Ajoutons une photo!</h2>";
        $errors = array(
            "author" => "",
            "descriptionP" => "",
            "dateP" => ""
        );
        /* montre le formulaire si les variables ne sont pas définies dans la requête POST */
        if (!isset($_POST["author"]) && !isset($_POST["title"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"])) {
            include_once("public/php/formulaire.php");
        } else {
            /* Attribution des variables */
            $author = key_exists('author', $_POST)? trim($_POST['author']): null;
            $title = key_exists('title', $_POST)? trim($_POST['title']): null;
            $descriptionP = key_exists('descriptionP', $_POST)? trim($_POST['descriptionP']): null;
            $dateP = key_exists('dateP', $_POST)? trim($_POST['dateP']): null;

            if ($author == "") $errors["nom"] = "Il manque le nom de l'auteur";
            if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
            if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";

            var_dump(count_errors($errors));
            if(count_errors($errors) == 0) {
                echo "oui!";
            } else {
                include_once("public/php/formulaire.php");
            }
        }
        break;
    case "list":
        $body = "<h2>Liste des photos!</h2>";
        break;
    default:
        $body = "<h2>Coucou!</h2>";
        break;
}

include_once("public/php/menu.php");  // gère le nav
include_once("public/php/squelette.php");  // gère la page principale