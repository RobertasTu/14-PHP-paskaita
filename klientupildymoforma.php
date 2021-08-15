
<?php 
require_once('connection.php');
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

<form action='klientupildymoforma.php' method='get'>
    <input type='text' name='vardas' placeholder='Iveskite Varda'/>
    <input type='text' placeholder='Iveskite Pavarde' name='pavarde'/>
    <select name='teises_id' id='teises_id'>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
    </select>


    <button type='submit' name='prideti'>Prideti nauja klienta</button>


</form>

<?php 

if(isset($_GET['prideti'])) {
    if(isset($_GET['vardas']) && !empty($_GET['vardas']) && isset($_GET['pavarde']) && !empty($_GET['pavarde']) && isset($_GET['teises_id']) && !empty($_GET['teises_id'])) {
        $vardas = $_GET['vardas'];
        $pavarde = $_GET['pavarde'];
        $teises_id = $_GET['teises_id'];

        
        
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


    
</body>
</html>



<?php 
// 1. Sukurti forma, kuri pagal ivestu duomenis issaugo duomenu bazes lenteleje Klientai
// 2. Papildyti dokumentą klientupildymoforma.php.
// *Po kliento pridėjimo, turi parodyti informaciją apie klientą. +
// *Tikrinti,ar teises_id laukelyje yra įvestas skaičius. +



?>