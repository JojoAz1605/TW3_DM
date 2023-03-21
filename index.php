<?php
$action = key_exists('action', $_GET)? trim($_GET['action']): null;

switch ($action) {
    case "add":
        $body = "<h2>Ajoutons une photo!</h2>";
        include_once("public/php/formulaire.php");
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