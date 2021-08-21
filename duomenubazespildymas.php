<!-- 1. Sukurti dokumentą duomenubazesupildymas.php. Šis dokumentas turi sukurti 200 įrašų Klientai lentelėje. +
2. Papildyti dokumentą klientupildymoforma.php.
*Po kliento pridėjimo, turi parodyti informaciją apie klientą. +
*Tikrinti,ar teises_id laukelyje yra įvestas skaičius.+
3. Sukurti dokumentą, klientai.php. Jame turi būti atvaizduojami visi klientai esantys duomenų bazėje.
4. Paspaudus ant kliento, turi būti įmanoma redaguoti jo duomenis ir išsaugoti.
5. Kiekvieną klientą turi būti galimybė ištrinti iš duomenų bazės. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klientu generavimas</title>
</head>
<body>
<form action='duomenubazespildymas.php' method='get'>
    <button type='submit' name='submit'>Sugeneruoti 200 atsitiktiniu klientu</button>
</form>


<?php 
require_once('connection.php');




 
if(isset($_GET['submit'])) {

        for($i=0; $i<200; $i++) {
            $vardas = 'vardas'.$i;
            $pavarde = 'pavarde'.$i;
            $teises_id = rand(1, 5);
            // array_push($klientai, new Klientai ('vardas'.($i+1), 'Pavarde'.($i+1), 'teises_id='.rand(1,3)));
            $sql = "INSERT INTO klientai(vardas, pavarde, teises_id) VALUES ('$vardas', '$pavarde', '$teises_id')";
                      
            if(mysqli_query($prisijungimas, $sql)) {
                echo 'vartototas yra pridetas';
                echo '<br>';
                // echo 'Kliento vardas'.$_GET['vardas'],.'Kliento pavarde'.$_GET['pavarde'],.'teises_id'.$_GET['teises_id'];
              } else {
                            echo 'Kazkas ivyko negerai';
                            echo '<br>';
          }     
            
            
        }
    }

        // mysqli_close($prisijungimas);  
 

// $klientaiObjektas = new Klientai();

?>
</body>
</html>