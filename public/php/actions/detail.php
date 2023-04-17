<?php

use classes\Photo;

$idP = key_exists('idP', $_GET) ? $_GET['idP'] : null;
$connection = connecter();

$prep_req = $connection->prepare("SELECT * FROM Photo WHERE idP=:idP");
$prep_req->execute(array(':idP' => $idP));
$data_photo = $prep_req->fetch();

$photo = new Photo($data_photo["author"], $data_photo["title"], $data_photo["descriptionP"], $data_photo["dateP"], $idP, $data_photo["dateS"]);

$body = $photo->show_detail();

$query = null;
$connection = null;