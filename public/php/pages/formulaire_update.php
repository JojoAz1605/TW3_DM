<?php

$body .= <<<HTML
<form method="post" action="/index.php?action=confirm" enctype="multipart/form-data">
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
    
    <input type='hidden' name='type' value='confirmupdate'>
    <input type='hidden' name='idP' value=$idP>
    <input type='hidden' name='sql' value='$req'>
    
    <button type="submit">Enregistrer</button>
</form>
HTML;
