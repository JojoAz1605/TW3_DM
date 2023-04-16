<?php
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
