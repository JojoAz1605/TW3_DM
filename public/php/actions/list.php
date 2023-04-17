<?php
use classes\Photo;

$body = "<h2>Liste des photos!</h2>";
$connection = connecter();

// On envoie la requête
$query  = $connection->query("SELECT * FROM Photo");

// On indique que nous utiliserons les résultats en tant qu'objet
$query->setFetchMode(PDO::FETCH_OBJ);

// Nous traitons les résultats en boucle
$body .= "<table><thead><tr><th>ID</th><th>Auteur</th><th>Titre</th><th>Actions</th></tr></thead><tbody>";

while($elem = $query->fetch()) {
    // Affichage des enregistrements
    $photo = new Photo($elem->author, $elem->title, $elem->descriptionP, $elem->dateP, $elem->idP, $elem->dateS);
    $body .= $photo->show_row();
}
$body .= "</tbody></table>";
