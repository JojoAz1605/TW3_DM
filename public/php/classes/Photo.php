<?php

namespace classes;

/**
 * Classe principale représentant les photos!
 * @author Joris MASSON
 * @package classes
 */
class Photo
{
    /**
     * @var int|null $idP L'ID de la photo.
     */
    private int|null $idP;

    /**
     * @var string|null $dateS La date de soumission de la photo
     *
     * Format: <code>Y-m-d H:i:s</code>(format TIMESTAMP SQL).
     */
    private string|null $dateS;

    /**
     * @var string $author L'auteur de la photo.
     */
    private string $author;

    /**
     * @var string $title Le titre de la photo(optionnel).
     */
    private string $title;

    /**
     * @var string $descriptionP La description de la photo.
     */
    private string $descriptionP;

    /**
     * @var string $dateP La date de prise de la photo.
     *
     * Format: <code>Y-m-d</code>(format DATE SQL).
     */
    private string $dateP;

    /**
     * Constructeur de la photo, initialise les attributs.
     * @param string $author L'auteur de la photo
     * @param string $title Le titre de la photo
     * @param string $descriptionP La description de la photo
     * @param string $dateP La date de prise de la photo(<code>Y-m-d</code>)
     * @param int|null $idP L'ID de la photo(pas obligatoire)
     * @param string|null $dateS La date de soumission de la photo(<code>Y-m-d H:i:s</code>)
     */
    public function __construct(string $author, string $title, string $descriptionP, string $dateP, int $idP = null, string $dateS = null)
    {
        $this->idP = $idP;
        $this->dateS = $dateS;
        $this->author = $author;
        $this->title = $title;
        $this->descriptionP = $descriptionP;
        $this->dateP = $dateP;
    }

    /**
     * Récupère les valeurs d'une photo d'un ID donné.
     * @param int $idP l'ID de la photo à récupérer
     * @return array
     */
    public static function fetch_all_values(int $idP): array
    {
        $connection = connecter();

        $prep_req = $connection->prepare("SELECT * FROM Photo WHERE idP=:idP");
        $prep_req->execute(array(':idP' => $idP));
        $connection = null;

        return $prep_req->fetch();
    }

    /**
     * Supprime la photo d'ID donné.
     * @param int $idP L'ID de la photo à supprimer
     * @return void
     */
    public static function delete_from_database(int $idP): void
    {
        $connection = connecter();
        $prep_req = $connection->prepare("DELETE FROM Photo WHERE idP=:ipP");
        $prep_req->execute(array(':ipP' => $idP));
        unlink("public/images/photos/$idP.png");

        $connection = null;
    }

    /**
     * Getter pour idP
     * @return int idP
     */
    public function get_idP(): int
    {
        return $this->idP;
    }

    /**
     * Getter pour dateS
     * @return string dateS
     */
    public function get_dateS(): string
    {
        return $this->dateS;
    }

    /**
     * Getter pour author
     * @return string author
     */
    public function get_author(): string
    {
        return $this->author;
    }

    /**
     * Getter pour title
     * @return string title
     */
    public function get_title(): string
    {
        return $this->title;
    }

    /**
     * Getter pour descriptionP
     * @return string descriptionP
     */
    public function get_descriptionP(): string
    {
        return $this->descriptionP;
    }

    /**
     * Getter pour dateP
     * @return string dateP
     */
    public function get_dateP(): string
    {
        return $this->dateP;
    }

    /**
     * Affichage HTML en ligne de tableau de la photo.
     * @return string HTML
     */
    public function show_row(): string
    {
        $auteur = htmlspecialchars($this->author);
        $titre = htmlspecialchars($this->title);
        return "<tr><td class='idP'>$this->idP</td><td class='author'>$auteur</td><td class='title'><a href='index.php?action=detail&idP=$this->idP'>$titre</a></td><td class='actions'><a id='delete' href='index.php?action=delete&idP=$this->idP'>Effacer</a><a href='index.php?action=update&idP=$this->idP'>Mettre à jour</a></td></tr>";
    }

    /**
     * Affichage HTML détaillé de la photo.
     * @return string HTML
     */
    public function show_detail(): string
    {
        $auteur = htmlspecialchars($this->author);
        $titre = htmlspecialchars($this->title);
        $desc = htmlspecialchars($this->descriptionP);
        return <<<HTML
                <h2>$auteur: <span class="photo_title">$titre</span></h2>
                <p>Description: $desc</p>              
                <img src='public/images/photos/$this->idP.png' alt='$this->title'>
                <p>La photo a été soumise le: <code>$this->dateS</code>, et prise le <code>$this->dateP</code></p>
                <a class="actions" id="update" href="/index.php?action=update&idP=$this->idP">Mettre à jour la photo</a>
                <a class="actions" id="delete" href="/index.php?action=delete&idP=$this->idP">Supprimer la photo</a>
                HTML;
    }

    /**
     * Insert dans la base de données les attributs actuels.
     * @return int l'ID de la photo une fois insérée dans la base de données
     */
    public function insert_to_database(): int
    {
        $connection = connecter();  // on se connecte à la database
        $prep_req = $connection->prepare("INSERT INTO Photo (dateS, author, title, descriptionP, dateP) VALUE (NOW(), :author, :title, :descriptionP, :dateP)");
        $prep_req->execute(array(
            ":author" => $this->author,
            ":title" => $this->title,
            ":descriptionP" => $this->descriptionP,
            ":dateP" => $this->dateP
        ));
        $this->idP = $connection->lastInsertId();
        $this->dateS = date('Y-m-d H:i:s', time());
        $connection = null;  // on ferme la connexion
        move_uploaded_file($_FILES["photo"]["tmp_name"], "public/images/photos/$this->idP.png");

        return $this->idP;
    }

    /**
     * Met à jour la photo dans la base de données avec les valeurs actuelles.
     * @return void
     */
    public function update_in_database(): void
    {
        $connection = connecter();
        $prep_req = $connection->prepare("UPDATE Photo SET author=:author, title=:title, descriptionP=:descriptionP, dateP=:dateP WHERE idP=:idP");
        $prep_req->execute(array(
            ":author" => $this->author,
            ":title" => $this->title,
            ":descriptionP" => $this->descriptionP,
            ":dateP" => $this->dateP,
            ":idP" => $this->idP
        ));

        /* vérifie si une nouvelle image a été envoyée */
        if (isset($_FILES["photo"])) {
            $file = $_FILES["photo"];
            move_uploaded_file($file["tmp_name"], "public/images/photos/$this->idP.png");
        }
        $connection = null;
    }
}