<?php
// TODO CSS des formulaires
require_once("public/php/utils.php");
require_once ("public/php/classes/Photo.php");
use classes\Photo;

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
            $author = trim($_POST['author']);
            $title = key_exists('title', $_POST)? $_POST['title']: "Sans titre";
            $descriptionP = trim($_POST['descriptionP']);
            $dateP = trim($_POST['dateP']);
            $photo = $_FILES["photo"];

            /* Check des erreurs */
            if ($author == "") $errors["author"] = "Il manque le nom de l'auteur";
            // le titre est optionnel
            if ($descriptionP == "") $errors["descriptionP"] = "Il manque une description à la photo";
            if ($dateP == "") $errors["dateP"] = "Il manque la date de prise de la photo";
            if ($photo["error"] == 4) $errors["photo"] = "Il manque le plus important: la photo!";  // code erreur 4 -> pas de fichier

            if(count_errors($errors) == 0) {
                $connection = connecter();
                $req = "INSERT INTO Photo (dateS, author, title, descriptionP, dateP) VALUE (NOW(), :author, :title, :descriptionP, :dateP)";
                $prep_req = $connection->prepare($req);
                $data = array(
                    ":author" => $author,
                    ":title" => $title,
                    ":descriptionP" => $descriptionP,
                    ":dateP" => $dateP
                );
                $prep_req->execute($data);
                move_uploaded_file($photo["tmp_name"], "public/images/photos/" . $connection->lastInsertId() . ".png");
                $body .= "<h2>Photo ajoutée!</h2>";
                $connection = null;
                $req = null;
            } else {include_once("public/php/pages/formulaire.php"); }
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
        $body .= "<table><thead><tr><th>ID</th><th>Auteur</th><th>Titre</th><th>Actions</th></tr></thead><tbody>";

        while($elem = $query->fetch()) {
            // Affichage des enregistrements
            $photo = new Photo($elem->idP, $elem->dateS, $elem->author, $elem->title, $elem->descriptionP, $elem->dateP);
            $body .= $photo->show_row();
        }
        $body .= "</tbody></table>";
        break;
    case "detail":
        $idP = key_exists('idP', $_GET)? $_GET['idP']: null;
        $connection = connecter();

        $prep_req = $connection->prepare("SELECT * FROM Photo WHERE idP=:idP");
        $prep_req->execute(array(':idP' => $idP));
        $data_photo = $prep_req->fetch();

        $photo = new Photo($idP, $data_photo["dateS"], $data_photo["author"], $data_photo["title"], $data_photo["descriptionP"], $data_photo["dateP"]);

        $body = $photo->show_detail();

        $query = null;
        $connection = null;
        break;
    case "delete":
        $idP = key_exists('idP', $_GET)? $_GET['idP']: null;

        $body = <<<HTML
        <form action='index.php?action=confirm' method='post'>
        <input type='hidden' name='type' value='confirmdelete'/>
        <input type='hidden' name='idP' value='$idP'/>
        Etes vous sûr de vouloir supprimer cette photo ?
        <p><input type='submit' value='delete'><a href='index.php?action=list'>Annuler</a></p>
        </form>
        HTML;
        break;
    case "update":
        $idP = key_exists('idP', $_GET)? $_GET['idP']: null;
        $connection = connecter();
        $req = "SELECT * FROM Photo WHERE idP=:idP";

        $prep_req = $connection->prepare($req);
        $data = array(':idP' => $idP);
        $prep_req->execute($data);
        $connection = null;

        $data_photo = $prep_req->fetch();
        $author = $data_photo["author"];
        $title = $data_photo["title"];
        $dateP = $data_photo["dateP"];
        $descriptionP = $data_photo["descriptionP"];

        $body = "<h1>Mise à jour de la photo $idP</h1>";
        include_once("public/php/pages/formulaire_update.php");
        break;
    case "confirm":
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
            $prep_req = $connection->prepare("DELETE FROM Photo WHERE idP=:ipP");
            $prep_req->execute(array(':ipP' => $idP));
            unlink("public/images/photos/$idP.png");
            $body = "<h2>Photo $idP supprimée!</h2>" ;
        }
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
