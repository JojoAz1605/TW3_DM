<?php
$body .= <<<HTML
<form method="post" action="/index.php">
    <label>Auteur</label>
    <input type="text" name="author">
    
    <label>Titre</label>
    <input type="text" name="title">
    
    <label>Description</label>
    <input type="text" name="descriptionP">
    
    <button type="submit">Enregistrer</button>
</form>
HTML;
