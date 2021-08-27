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
    <title>Įmonės pildymo forma</title>
</head>
<style>
        h1 {
            text-align: center;
        }

        /* .container {
            position:absolute;
            top:50%;
            left:50%;
            transform: translateY(-50%) translateX(-50%);
        } */
       
    </style>
<body>
<div class='container'>
<form action='imonespildymoforma.php' method='post'>
    <input type='text' name='pavadinimas' placeholder='Iveskite pavadinima'/>
    <input type='text' placeholder='Iveskite aprasyma' name='aprasymas'/>
    <select name='tipas_ID' id='tipas_ID'>
        <?php
            $sql = "SELECT * FROM imones_tipas ";
            $rezultatas = $prisijungimas->query($sql);
            while($imones_tipas = mysqli_fetch_array($rezultatas)) {
                if($imones_tipas['tipas_ID'] == $imonesTipas['pavadinimas']) {
                    echo "<option value='".$imones_tipas['pavadinimas']."' selected='true'>";

                } else {
                    echo "<option value='".$imones_tipas['pavadinimas']."'>";
                }
                    echo $imones_tipas['pavadinimas'];
                    echo "</option>";
            }
            ?>
        <!-- <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option> -->
    </select>


    <button class='btn btn-primary' type='submit' name='prideti'>Prideti nauja įmonę</button>
<a href='imones.php'>Atgal</a>

</form>

</div>

<?php 

if(isset($_POST['prideti'])) {
    if(isset($_POST['pavadinimas']) && !empty($_POST['pavadinimas']) && isset($_POST['aprasymas']) && !empty($_POST['aprasymas']) && isset($_POST['tipas_ID']) && !empty($_POST['tipas_ID'])) {
        $pavadinimas = $_POST['pavadinimas'];
        $tipas_ID = $_POST['tipas_ID'];
        $aprasymas = $_POST['aprasymas'];

        
        
        $sql = "INSERT INTO imones(pavadinimas, tipas_ID, aprasymas) VALUES ('$pavadinimas', $tipas_ID, '$aprasymas')";

        if(mysqli_query($prisijungimas, $sql)) {
              echo 'Imonė yra pridėta';
              echo '<br>';
              echo 'Pavadinimas:'.$pavadinimas.'<br>'; 
              echo 'tipas_ID:'.$tipas_ID.'<br>';
              echo 'Aprasymas:'.$aprasymas.'<br>';
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