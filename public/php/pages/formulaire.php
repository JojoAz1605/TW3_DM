<?php
/**
 * Le formulaire d'ajout d'une photo dans la base de données.
 * @author Joris MASSON
 * @author Le cours
 */
if (!empty($photo)) {
    $author = $photo->get_author();
    $title = $photo->get_title();
    $descriptionP = $photo->get_descriptionP();
    $dateP = $photo->get_dateP();
}

$body .= <<<HTML
<form method="post" action="index.php?action=add" enctype="multipart/form-data">
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
        <span class="error">{$errors["photo"]}</span><br/>
    </label>
    
    <button type="submit">Enregistrer</button>
</form>
HTML;
