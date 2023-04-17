<?php
/**
 * Index du site, c'est ici que tout est décidé.
 * @author Joris MASSON
 */

// TODO CSS des formulaires
require_once("public/php/utils.php");
require_once("public/php/classes/Photo.php");

$action = key_exists('action', $_GET) ? trim($_GET['action']) : null;

/* variables importantes */
$errors = array("author" => null, "descriptionP" => null, "dateP" => null, "photo" => null);  // pour la gestion des erreurs de formulaire
$author = null;
$title = null;
$descriptionP = null;
$dateP = null;
$photo = null;  // pour éviter les erreurs

switch ($action) {
    case "add":
        require_once "public/php/actions/add.php";
        break;
    case "list":
        require_once "public/php/actions/list.php";
        break;
    case "detail":
        require_once "public/php/actions/detail.php";
        break;
    case "delete":
        include_once "public/php/actions/delete.php";
        break;
    case "update":
        include_once "public/php/actions/update.php";
        break;
    case "confirm":
        include_once "public/php/actions/confirm.php";
        break;
    case "about":
        include_once("public/php/pages/about.php");
        break;
    default:
        $body = "<h2>Coucou!</h2>";
        break;
}

include_once("public/php/pages/menu.php");  // gère le nav
include_once("public/html/squelette.html");  // gère la page principale
