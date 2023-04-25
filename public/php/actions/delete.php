<?php
/**
 * Action à réaliser lors de <code>delete</code>: prépare la suppression d'une photo en demandant confirmation.
 * @author Joris MASSON
 * @package actions
 */

$idP = key_exists('idP', $_GET) ? $_GET['idP'] : null;

if (!is_numeric($_GET["idP"])) {
    $body = "<h2 class='error'>Erreur, idP incorrect.</h2>";
} else {
    $body = <<<HTML
                <form action='index.php?action=confirm' method='post'>
                <input type='hidden' name='type' value='confirmdelete'/>
                <input type='hidden' name='idP' value='$idP'/>
                Etes vous sûr de vouloir supprimer cette photo ?
                <p><input class="confirm-button" type='submit' value='delete'><a href='index.php?action=list'>Annuler</a></p>
                </form>
                HTML;
}
