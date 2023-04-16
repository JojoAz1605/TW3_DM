<?php

namespace classes;

class Photo {
    private $idP;
    private $dateS;
    private $author;
    private $title;
    private $descriptionP;
    private $dateP;

    public function __construct($idP, $dateS, $author, $title, $descriptionP, $dateP) {
        $this->idP = $idP;
        $this->dateS = $dateS;
        $this->author = $author;
        $this->title = $title;
        $this->descriptionP = $descriptionP;
        $this->dateP = $dateP;
    }

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
}