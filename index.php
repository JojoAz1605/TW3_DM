<?php
require_once("public/php/utils.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$errors = array(
    "author" => null,
    "descriptionP" => null,
    "dateP" => null
);
$author = null;
$title = null;
$descriptionP = null;
$dateP = null;

switch ($action) {
    case "add":
        $body = "<h2>Ajoutons une photo!</h2>";
        /* montre le formulaire si les variables ne sont pas définies dans la requête POST */
        if (!isset($_POST["author"]) && !isset($_POST["title"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"])) {
            include_once("public/php/pages/formulaire.php");
        } else {
            /* Attribution des variables */
            $author = key_exists('author', $_POST)? trim($_POST['author']): null;
            $title = key_exists('title', $_POST)? trim($_POST['title']): null;
            $descriptionP = key_exists('descriptionP', $_POST)? trim($_POST['descriptionP']): null;
            $dateP = key_exists('dateP', $_POST)? trim($_POST['dateP']): null;

            /* Check des erreurs */
            if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
            if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
            if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";

            if(count_errors($errors) == 0) {
                $connexion = connecter();
                $req = "INSERT INTO Photo (dateS, author, title, descriptionP, dateP) VALUE (NOW(), :author, :title, :descriptionP, :dateP)";
                $prep_req = $connexion->prepare($req);
                $data = array(
                    ":author" => $author,
                    ":title" => $title,
                    ":descriptionP" => $descriptionP,
                    ":dateP" => $dateP
                );
                $prep_req->execute($data);
                $body .= "Photo ajoutée!";
            } else {include_once("public/php/pages/formulaire.php");}
        }
        break;
    case "list":
        $body = "<h2>Liste des photos!</h2>";
        $connection = connecter();
        $req = "SELECT * FROM Photo";

        // On envois la requète
        $query  = $connection->query($req);

        // On indique que nous utiliserons les résultats en tant qu'objet
        $query->setFetchMode(PDO::FETCH_OBJ);

        // Nous traitons les résultats en boucle
        $body .= "<h4><span class='c1'><b><u>Id de la photo</u></span> <span class='c1'>Nom de l'auteur</span><span class='c1'>Titre de la photo</span>  </span><span class='c1'>Action</b></span></h4>";

        while($enregistrement = $query->fetch()) {
            // Affichage des enregistrements
            $idP = $enregistrement->idP;
            $author = $enregistrement->author;
            $title = $enregistrement->title;
            $tab_Personne[$idP] = array($title, $title);
            $body .= "<span class='c1'><u><b>" . $idP . "</b></u></span> <span class='c1'>" . $author . " </span><span class='c1'>" . $title . "</span>";
            $body .= '<span class=\'c1\'><a href="index.php?action=select&idP=' . $idP . '"><span class="glyphicon glyphicon-eye-open"></span></a>';
            $body .= '<a href="index.php?action=update&idP=' . $idP . '"><span class="glyphicon glyphicon-pencil"></span></a>';
            $body .= '<a href="index.php?action=delete&idP=' . $idP . '"><span class="glyphicon glyphicon-trash"></span></a></span>';
            $body .= "<br>";
        }
        break;
    case "about":
        include_once("public/php/pages/about.php");
        break;
    default:
        $body = "<h2>Coucou!</h2>";
        break;
}

include_once("public/php/pages/menu.php");  // gère le nav
include_once("public/php/pages/squelette.php");  // gère la page principale