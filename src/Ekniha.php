<?php

namespace App;
use PDO;

    class Ekniha extends Kniha{
    private float $velkostSuboru;

    public function __construct($nazov, $autor, $isbn, $dostupnost, $velkostSuboru)
    {
        parent::__construct($nazov, $autor, $isbn, $dostupnost);
        $this->velkostSuboru = $velkostSuboru;
    }

    public function stiahni(){
        echo "Stahujem eknihu .... Velkost suboru je {$this->velkostSuboru} MB.<br>";
    }

    public function getInfo(){
        $zakladneInfo = parent::getInfo();

    return $zakladneInfo."Velkost suboru: ".$this->velkostSuboru."MB.<br>";
    }

    public function getVelkostSuboru(){
        return $this->velkostSuboru;
    }

    public function pridajKnihu($db){
        $sql = "INSERT INTO knihy(nazov, autor, isbn, dostupnost, typ, velkostMB) VALUE (:nazov, :autor, :isbn, :dostupnost, 'elektronicka', :velkostSuboru)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":nazov", $this->nazov);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":dostupnost", $this->dostupnost);
        $stmt->bindParam(":velkostSuboru", $this->velkostSuboru);
            
        if($stmt->execute()){
            return true;
        } 

    return false;
    }

}