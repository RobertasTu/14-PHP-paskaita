<?php 
require_once('connection.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Įmonės pildymo forma</title>
    <?php require_once("includes.php"); ?>
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
<?php 

if(!isset($_COOKIE["prisijungti"])) { 
    header("Location: login.php");    
} else {
    $cookie_text = $_COOKIE["prisijungti"];
    $cookie_array = explode("|", $cookie_text );
    $cookie_vardas = $cookie_array[1];
    echo "Sveikas prisijunges: ".$cookie_vardas;
    echo "<form action='klientai.php' method ='get'>";
    // echo "<button class='btn btn-primary' type='submit' name='vartotojai'>Vartotojų duomenų bazė</button>";
    // echo "<button class='btn btn-primary' type='submit' name='imones'>Imonių duomenų bazė</button>";
    echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    echo "</form>";
    // if(isset($_GET['vartotojai'])) {
    //   header('Location: vartotojai.php');
    // }
    // if(isset($_GET['imones'])) {
    //   header('Location: imones.php');
    // }

    if(isset($_GET["logout"])) {
        setcookie("prisijungti", "", time() - 3600, "/");
        header("Location: login.php");
    }
}    
?>
<?php 

if(isset($_POST['prideti'])) {
    if(isset($_POST['pavadinimas']) && !empty($_POST['pavadinimas']) && isset($_POST['aprasymas']) && !empty($_POST['aprasymas']) && isset($_POST['tipas_ID']) && !empty($_POST['tipas_ID'])) {
        $pavadinimas = $_POST['pavadinimas'];
        $tipas_ID = intval($_POST['tipas_ID']);
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
                $message =  "Kazkas ivyko negerai";
                $class = "danger";
                          
        }
    }  else {
        $message =  "Uzpildykite visus laukelius";
        $class = "danger";
    }
}
?>
<div class='container'>
<?php require_once("menu/includes.php"); ?>
<h1>Nauja įmonė</h1>
<form action='imonespildymoforma.php' method='post'>
<div class="form-group">
     <label for="pavadinimas">Pavadinimas:</label>
    <input type='text' class='form-control' name='pavadinimas' placeholder='Iveskite pavadinima'/>
</div>
<div class="form-group">
    <label for="aprasymas">Aprašymas:</label>
    <input type='text' class='form-control' placeholder='Iveskite aprašymą' name='aprasymas'/>
</div>
<div class="form-group">
        <label for="tipas_id">Tipas:</label>
    <select name='tipas_ID' class='form-control' id='tipas_ID'>
        <?php
            $sql = "SELECT * FROM imones_tipas ";
            $rezultatas = $prisijungimas->query($sql);
            while($imones_tipas = mysqli_fetch_array($rezultatas)) {
                if($imones_tipas['tipas_ID'] == $imonesTipas['aprasymas']) {
                    echo "<option value='".$imones_tipas['aprasymas']."' selected='true'>";

                } else {
                    echo "<option value='".$imones_tipas['aprasymas']."'>";
                }
                    echo $imones_tipas['aprasymas'];
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
<?php if(isset($message)) { ?>
                <div class="alert alert-<?php echo $class; ?>" role="alert">
                <?php echo $message; ?>
                </div>
            <?php } ?>

</div>




    
</body>
</html>



<?php 