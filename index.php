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

//$sandokan = new Ekniha("sandokan", "Adam Hruska", "789456",1, 500);
//$husar = new Kniha("husar", "Jan Hus", "12345",1);

//$sandokan->pridajKnihu($db);
//$husar->pridajKnihu($db);

//spracovanie formulara

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pridaj"])){
    $nazov = $_POST["nazov"];
    $autor = $_POST["autor"];
    $isbn = $_POST["isbn"];
    $typ = $_POST["typ"];
    $velkost = $_POST["velkost"];

    if($typ === "papierova"){
        $novaKniha = new Kniha($nazov, $autor, $isbn, 1);
    }else{
        $novaKniha = new Ekniha($nazov, $autor, $isbn, 1, $velkost);
    }

    if($novaKniha->pridajKnihu($db)){
        echo "<p style='color:green'> Kniha uspesne pridana!!!";
    }

}





/*
$kniznica = Kniha::vsetkyKnihy($db);

foreach($kniznica as $kniha){
    echo $kniha->getInfo();
}
*/


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="nazov" placeholder="Názov" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        
        <select name="typ" id="typKnihy" onchange="toggleSize()">
            <option value="papierova">Papierová</option>
            <option value="ekniha">E-kniha</option>
        </select>

        <input type="number" name="velkost" id="velkostInput" placeholder="Veľkosť v MB" step="0.1" style="display:none;">
        
        <button type="submit" name="pridaj">Pridať do knižnice</button>
    </form>

    <script>
    function toggleSize() {
        const typ = document.getElementById('typKnihy').value;
        const input = document.getElementById('velkostInput');
        input.style.display = (typ === 'ekniha') ? 'inline' : 'none';
    }
    </script>
</body>
</html>




