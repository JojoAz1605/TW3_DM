<?php
/**
 * Action à réaliser lors de <code>confirm</code>: update ou supprime une photo de la base de données.
 *
 * L'action à réaliser est décidée grâce à une valeur transmise via POST: <code>type</code>:
 *
 * -<code>confirmupdate</code> -> update une photo.
 *
 * -<code>confirmdelete</code> -> supprime une photo.
 * @author Joris MASSON
 * @package actions
 * @uses Photo
 */

use classes\Photo;

/* récupère les valeurs de la requête POST */
$idP = key_exists('idP', $_POST) ? $_POST['idP'] : null;
$type = key_exists('type', $_POST) ? $_POST['type'] : null;

if ($type == 'confirmupdate') {
    $body = "<h1>Mise à jour de la photo $idP</h1>";
    $photo = new Photo(
        $_POST['author'],
        $_POST['title'],
        $_POST['descriptionP'],
        $_POST['dateP'],
        $_POST['idP']
    );
    $photo->update_in_database();
    $body .= "<h2>Photo mise à jour!</h2>";
} else if ($type == "confirmdelete") {
    Photo::delete_from_database($idP);
    $body = "<h2>Photo $idP supprimée!</h2>";
}
