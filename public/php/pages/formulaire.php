<?php
$body .= <<<HTML
<form method="post" action="/index.php?action=add" enctype="multipart/form-data">
    <label>Auteur
        <input type="text" name="author" value="$author">
        <span class="error">{$errors["author"]}</span><br/>
    </label>
    
    <label>(Titre
        <input type="text" name="title" value="$title">)
        <br>
    </label>
    
    <label>Description
        <input type="text" name="descriptionP" value="$descriptionP">
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
