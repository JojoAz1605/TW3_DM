<?php

namespace classes;

class Photo {
    private $idP;
    private $dateS;
    private $author;
    private $title;
    private $descriptionP;
    private $dateP;

    public function __construct($author, $title, $descriptionP, $dateP, $idP=null, $dateS=null) {
        $this->idP = $idP;
        $this->dateS = $dateS;
        $this->author = $author;
        $this->title = $title;
        $this->descriptionP = $descriptionP;
        $this->dateP = $dateP;
    }

    public function get_idP(): int{return $this->idP; }
    public function get_dateS(): string {return $this->dateS; }
    public function get_author(): string {return $this->author; }
    public function get_title(): string {return $this->title; }
    public function get_descriptionP(): string {return $this->descriptionP; }
    public function get_dateP(): string {return $this->dateP; }

    public function show_row(): string {
        return "<tr><td class='idP'>$this->idP</td><td class='author'>$this->author</td><td class='title'><a href='index.php?action=detail&idP=$this->idP'>$this->title</a></td><td class='actions'><a href='index.php?action=delete&idP=$this->idP'>Effacer</a><a href='index.php?action=update&idP=$this->idP'>Mettre à jour</a></td></tr>";
    }

    public function show_detail(): string {
        return <<<HTML
                <h2>$this->author: <span class="photo_title">$this->title</span></h2>
                <p>Description: $this->descriptionP</p>              
                <img src='public/images/photos/$this->idP.png' alt='$this->title'>
                <p>La photo a été soumise le: <code>$this->dateS</code>, et prise le <code>$this->dateP</code></p>
                HTML;
    }

    public static function fetch_all_values($idP) {
        $connection = connecter();

        $prep_req = $connection->prepare("SELECT * FROM Photo WHERE idP=:idP");
        $prep_req->execute(array(':idP' => $idP));
        $connection = null;

        return $prep_req->fetch();
    }

    public function insert_to_database() : int {
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

        return $this->idP;
    }

    public static function delete_from_database($idP): void {
        $connection = connecter();
        $prep_req = $connection->prepare("DELETE FROM Photo WHERE idP=:ipP");
        $prep_req->execute(array(':ipP' => $idP));
        unlink("public/images/photos/$idP.png");

        $connection = null;
    }

    public function update_in_database(): void {
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