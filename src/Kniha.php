<?php

namespace App;
use PDO;

class Kniha
{
    private string $nazov;
    private string $autor;
    private string $ISBN;
    private bool $dostupnost = false;

    public function __construct($nazov, $autor, $ISBN, $dostupnost){
        $this->nazov = $nazov;
        $this->autor = $autor;
        $this->ISBN = $ISBN;
        $this->dostupnost = $dostupnost;
    }

    public function getInfo(){
        return "Nazov knihy: {$this->nazov}<br>Autor knihy: {$this->autor}<br>Kod ISBN: {$this->ISBN}<br>Stav: {$this->dostupnost}";
    }

}