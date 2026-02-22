<?php

require_once 'vendor/autoload.php';

use App\Database;
use App\Kniha;
use App\Ekniha;


$connect = new Database();
$db = $connect->pripojDb();

if($db){
  /*
    $dunaj = new Kniha("Princ", "Milan Stodola","258",1);
    
    if($dunaj->pridajKnihu($db)){
        echo "Kniha bola pridana";
    }else{
        echo "Kniha sa nepodarila pridat";
    }
   
 
  
    $isbn = "12345678";
    $kniha = Kniha::hladajPodlaIsbn($db, $isbn);

    echo $kniha->getInfo();
    $kniha->pozicaj();
    $kniha->ulozZmeny($db);
    echo "Zmena bola zapisana<br>";
    echo $kniha->getInfo();
   
  $zoznam = Kniha::vsetkyKnihy($db);
  

    $isbn = "123";
    $kniha = Kniha::zmazKnihu($db, $isbn);

    if($kniha){
        echo "kniha bola zmazana!!!";
    }else{
        echo "Kniha sa v databaze nenachadza!!!";
    }
*/

$sandokan = new Ekniha("sandokan", "Adam Hruska", "789456",1, 500);
$husar = new Kniha("husar", "Jan Hus", "12345",1);

$sandokan->pridajKnihu($db);
$husar->pridajKnihu($db);

$kniznica = Kniha::vsetkyKnihy($db);

foreach($kniznica as $kniha){
    echo $kniha->getInfo();
}



}




