<?php

namespace App;
use PDO;

class Kniha
{
    private string $nazov;
    private string $autor;
    private string $isbn;
    private int $dostupnost;

    public function __construct($nazov, $autor, $isbn, $dostupnost){
        $this->nazov = $nazov;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->dostupnost = $dostupnost;
    }

    public function getInfo(){
        return "Nazov knihy: {$this->nazov}<br>Autor knihy: {$this->autor}<br>Kod ISBN: {$this->isbn}<br>Stav: {$this->dostupnost}";
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

    public function pridajKnihu($db){
        $sql = "INSERT INTO knihy(nazov, autor, isbn, dostupnost) VALUE (:nazov, :autor, :isbn, :dostupnost)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":nazov", $this->nazov);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":dostupnost", $this->dostupnost);
    
        if($stmt->execute()){
            return true;
        } 

        return false;
    }
}