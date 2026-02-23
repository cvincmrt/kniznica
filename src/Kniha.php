<?php

namespace App;
use PDO;

class Kniha
{
    protected string $nazov;
    protected string $autor;
    protected string $isbn;
    protected int $dostupnost;
    

    public function __construct($nazov, $autor, $isbn, $dostupnost){
        $this->nazov = $nazov;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->dostupnost = $dostupnost;
       
    }

    public function getInfo(){
        return "Nazov knihy: {$this->nazov}<br>Autor knihy: {$this->autor}<br>Kod ISBN: {$this->isbn}<br>Stav: {$this->dostupnost}<br>";
    }

    public function getNazov(){
        return $this->nazov;
    }

    public function pozicaj(){
        if($this->dostupnost){
            $this->dostupnost = 0;
        }else{
            echo "Chyba: Kniha je uz pozicana!<br>";
        }
    }

    public function vrat(){
        $this->dostupnost = 1;
    }

    public function pridajKnihu($db){
        $sql = "INSERT INTO knihy(nazov, autor, isbn, dostupnost, typ) VALUE (:nazov, :autor, :isbn, :dostupnost, 'papierova')";

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

    public static function hladajPodlaIsbn($db, $isbn){
        $sql = "SELECT nazov, autor, isbn, dostupnost, typ FROM knihy WHERE isbn = :isbn";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":isbn", $isbn);

        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $objekt = new Kniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"]);
            return $objekt;
        }else{
            return null;
        }
    }

    public function ulozZmeny($db){
        $sql = "UPDATE knihy SET dostupnost = :dostupnost WHERE isbn = :isbn" ;

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":dostupnost", $this->dostupnost);
        $stmt->bindParam(":isbn", $this->isbn);
        
    return $stmt->execute();
    }
    
    public static function vsetkyKnihy($db){
        $zoznamKnih = [];
        $sql = "SELECT * FROM knihy";

        $stmt = $db->query($sql);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($row["typ"] === "papierova"){
                $kniha = new Kniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"]);
                $zoznamKnih[] = $kniha;
            }else{
                $kniha = new Ekniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"],$row["velkostMB"]);
                $zoznamKnih[] = $kniha;
            }
          
        }
    return $zoznamKnih;
    }

    public static function zmazKnihu($db, $isbn){
        $sql = "DELETE FROM knihy WHERE isbn = :isbn";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":isbn", $isbn);

        if($stmt->execute()){
            return true;
        }
    return false;    
    }

}