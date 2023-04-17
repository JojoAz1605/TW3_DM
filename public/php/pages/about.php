<?php
/**
 * La page "à propos" du site!
 * @author Joris MASSON
 */
// TODO finir le about
$body = <<<HTML
<h2>À propos!</h2>

<h3>Auteur du site</h3>
<p class="about">
    Nom Prénom: Masson Joris<br>
    Numéro d'étudiant: <code>22008229</code><br>
    Groupe de TP: <code>2A</code><br>
</p>

<h3>Points réalisés</h3>
<ul class="about">
    <li>Opérations de base de données
        <ul>
            <li>Listage des photos</li>
            <li>Affichage des détails d'une photo</li>
            <li>Ajout des données d'une photo dans la base de données, la photo est gardée dans un dossier du serveur</li>
            <li>Suppression d'une photo dans la base de données, l'image est supprimée également</li>
            <li>Mettre à jour une photo dans la base de données, l'image est mise à jour uniquement si une nouvelle est uploadée</li>   
        </ul>
    </li>
    <li>Demande de confirmation avant de supprimer ou de mettre à jour une photo dans la base de données</li>
    <li>Manipulation des photos avec une classe <code>Photo</code></li>
    <li>[Complément] Les photos sont illustrées par... des photos!</li>
</ul>

<h3>Choix du sujet</h3>
<p class="about">
    Ce sujet a été choisi car je pensais pouvoir réussir à faire d'une pierre deux coups avec un projet personnel.<br>
    Étant programmeur à mes heures perdues pour un serveur Discord centré sur le lore du jeu Genshin Impact, un jour, plusieurs de nos membres ont eue 
    l'idée de faire un concours photo du jeu sur le serveur.<br>
    Lors du deuxième concours, j'ai décidé de faire un petit site fonctionnant avec NodeJS pour pouvoir voter et décider du gagnant.<br>
    Ensuite, pour le troisième concours, j'ai ajouté une commande au bot Discord que j'ai créé afin de pouvoir automatiser l'envoi des participations
    de chacun.<br>
    Avec ceci, tout pourra être sur le même site directement, après quelques ajouts!<br>
    Tout le site a été réalisé dans le cadre du DM.
</p>
HTML;
