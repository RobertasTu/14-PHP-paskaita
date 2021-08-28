
<?php 
require_once('connection.php');
require_once('includes.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klientu pildymo forma</title>
</head>
<body>

<div class='container'>
<?php require_once("menu/includes.php"); ?>

<form action='klientupildymoforma.php' method='get'>
    <input type='text' name='vardas' placeholder='Iveskite Varda'/>
    <input type='text' placeholder='Iveskite Pavarde' name='pavarde'/>
    <select name='teises_id' id='teises_id'>
    <?php 
                         $sql = "SELECT * FROM klientai_teises";
                         $rezultatas = $prisijungimas->query($sql);
                     
                         while($klientaiTeises = mysqli_fetch_array($rezultatas)) {

                            if($klientas["teises_id"] == $klientaiTeises["reiksme"] ) {
                                echo "<option value='".$klientaiTeises["reiksme"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$klientaiTeises["reiksme"]."'>";
                            }  
                                
                                echo $klientaiTeises["pavadinimas"];
                            echo "</option>";
                        }
                        ?>
    </select>


    <button class='btn btn-primary' type='submit' name='prideti'>Prideti nauja klienta</button>
    <a href='klientai.php'>Atgal</a>

</form>

<?php 

if(isset($_GET['prideti'])) {
    if(isset($_GET['vardas']) && !empty($_GET['vardas']) && isset($_GET['pavarde']) && !empty($_GET['pavarde']) && isset($_GET['teises_id']) && !empty($_GET['teises_id'])) {
        $vardas = $_GET['vardas'];
        $pavarde = $_GET['pavarde'];
        $teises_id = intval($_GET['teises_id']);

        
        
        $sql = "INSERT INTO klientai(vardas, pavarde, teises_id) VALUES ('$vardas', '$pavarde', $teises_id)";

        if(mysqli_query($prisijungimas, $sql)) {
              echo 'Irasas yra pridetas';
              echo '<br>';
              echo 'Vardas:'.$vardas.'<br>'; 
              echo 'Pavarde:'.$pavarde.'<br>';
              echo 'Teises_id:'.$teises_id.'<br>';
              echo '<br>';
            //   echo 'Kliento vardas'.$_GET['vardas'],.'Kliento pavarde'.$_GET['pavarde'],.'teises_id'.$_GET['teises_id'];
            } else {
                          echo 'Kazkas ivyko negerai';
        }
    }
}
?>
</div>





    
</body>
</html>



<?php 
// 1. Sukurti forma, kuri pagal ivestu duomenis issaugo duomenu bazes lenteleje Klientai
// 2. Papildyti dokumentą klientupildymoforma.php.
// *Po kliento pridėjimo, turi parodyti informaciją apie klientą. +
// *Tikrinti,ar teises_id laukelyje yra įvestas skaičius. +



?>