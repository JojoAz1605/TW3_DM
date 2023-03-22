<?php
require_once("public/php/utils.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$errors = array(
    "author" => null,
    "descriptionP" => null,
    "dateP" => null,
    "photo" => null
);
$author = null;
$title = null;
$descriptionP = null;
$dateP = null;
$photo = null;

switch ($action) {
    case "add":
        $body = "<h2>Ajoutons une photo!</h2>";
        /* montre le formulaire si les variables ne sont pas définies dans la requête POST */
        if (!isset($_POST["author"]) && !isset($_POST["title"]) && !isset($_POST["descriptionP"]) && !isset($_POST["dateP"]) && !isset($_FILES["photo"])) {
            include_once("public/php/pages/formulaire.php");
        } else {
            /* Attribution des variables */
            $author = key_exists('author', $_POST)? trim($_POST['author']): null;
            $title = key_exists('title', $_POST)? trim($_POST['title']): null;
            $descriptionP = key_exists('descriptionP', $_POST)? trim($_POST['descriptionP']): null;
            $dateP = key_exists('dateP', $_POST)? trim($_POST['dateP']): null;
            $photo = $_FILES["photo"];

            /* Check des erreurs */
            if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
            if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
            if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";
            if ($photo["error"] == 4) $errors["photo"] = "Il manque le plus important: la photo!";  // code erreur 4 -> pas de fichier

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
                move_uploaded_file($photo["tmp_name"], "public/images/photos/" . $connexion->lastInsertId() . ".png");
                $body .= "Photo ajoutée!";
                $connexion = null;
                $req = null;
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
            $body .= "<span class='c1'><u><b>" . $idP . "</b></u></span> <span class='c1'>" . $author . " </span><span class='c1'><a href='index.php?action=details&idP=$idP'>" . $title . "</a></span>";
            $body .= "<br>";
        }
        break;
    case "details":
        $idP = key_exists('idP',$_GET)? $_GET['idP']: null;
        $connection = connecter();
        $req = "SELECT * FROM Photo WHERE idP=:idP";

        $prep_req = $connection->prepare($req);
        $data = array(':idP' => $idP);
        $prep_req->execute($data);
        $data_photo = $prep_req->fetch();
        $author = $data_photo["author"];
        $title = $data_photo["title"];
        $dateP = $data_photo["dateP"];
        $descriptionP = $data_photo["descriptionP"];
        $dateS = $data_photo["dateS"];

        $body = "<h1>$author: $title</h1>";
        $body .= "<h2>Soumis le: $dateS</h2>";
        $body .= "<h2>Prise le: $dateP</h2>";
        $body .= "<p>Description: $descriptionP</p>";
        $body .= "<img src='public/images/photos/$idP.png' alt='$title'>";

        $query = null;
        $connection = null;
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