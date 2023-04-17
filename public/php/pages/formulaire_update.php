<?php
/**
 * Le formulaire d'update d'une photo dans la base de données.
 * @author Joris MASSON
 * @author Le cours
 */

$body .= <<<HTML
<form method="post" action="/index.php?action=update&idP=$idP" enctype="multipart/form-data">
    <label>Auteur
        <input type="text" name="author" value="$author">
        <span class="error">{$errors["author"]}</span><br/>
    </label>
    
    <label>(Titre
        <input type="text" name="title" value="$title">)
        <br>
    </label>
    
    <label>Description
        <textarea name="descriptionP" rows="10" cols="50">$descriptionP</textarea>
        <span class="error">{$errors["descriptionP"]}</span><br/>
    </label>
    
    <label>Date de prise
        <input type="date" name="dateP" value="$dateP">
        <span class="error">{$errors["dateP"]}</span><br/>
    </label>
    
    <label>Photo
        <input type="file" name="photo">
    </label>
    <img src='public/images/photos/$idP.png' alt='$title'>
    
    <button type="submit">Enregistrer</button>
</form>
HTML;
