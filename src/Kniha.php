<?php

namespace App;
use PDO;

class Kniha
{
    private string $nazov;
    private string $autor;
    private string $ISBN;
    private int $dostupnost;

    public function __construct($nazov, $autor, $ISBN, $dostupnost){
        $this->nazov = $nazov;
        $this->autor = $autor;
        $this->ISBN = $ISBN;
        $this->dostupnost = $dostupnost;
    }

    public function getInfo(){
        return "Nazov knihy: {$this->nazov}<br>Autor knihy: {$this->autor}<br>Kod ISBN: {$this->ISBN}<br>Stav: {$this->dostupnost}";
    }

    public function pozicaj(){
        if($this->dostupnost){
            $this->dostupnost = 0;
        }else{
            echo "Chyba: Kniha je uz pozicana!";
        }
    }

    public function vrat(){
        $this->dostupnost = 1;
    }

}