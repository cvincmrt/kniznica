<?php

require_once 'vendor/autoload.php';

use App\Database;
use App\Kniha;
use App\Ekniha;


$connect = new Database();
$db = $connect->pripojDb();

if(!$db){
    die("Chyba pripojenia k databaze!!!!");
}

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
        header("Location: index.php?success=1");
        exit;
    }

}

$kniznica = Kniha::vsetkyKnihy($db);



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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f9f9f9; }
        .status-volna { color: green; font-weight: bold; }
        .status-pozicana { color: red; font-weight: bold; }
        .typ-tag { background: #eee; padding: 2px 6px; border-radius: 4px; font-size: 0.8em; }
    </style>
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
   
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; background: #e8f5e9; padding: 10px;">
            ✅ Kniha bola úspešne pridaná do knižnice!
        </p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Názov</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Typ</th>
                <th>Stav</th>
                <th>Informacie</th>                
            </tr>
        </thead>

    </table>

    <script>
    function toggleSize() {
        const typ = document.getElementById('typKnihy').value;
        const input = document.getElementById('velkostInput');
        input.style.display = (typ === 'ekniha') ? 'inline' : 'none';
    }
    </script>
</body>
</html>




