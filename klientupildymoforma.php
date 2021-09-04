
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

    <?php require_once("includes.php"); ?>
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

        .hide {
            display:none;
        }
    </style>
</head>
<body>
<div class='container'>
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

if(isset($_GET['prideti'])) {
    if(isset($_GET['vardas']) && !empty($_GET['vardas']) && isset($_GET['pavarde']) && !empty($_GET['pavarde']) && isset($_GET['teises_id']) ) {
        $vardas = $_GET['vardas'];
        $pavarde = $_GET['pavarde'];
        $teises_id = intval($_GET['teises_id']);
        $pridejimo_data = date ("Y-m-d");

        
        
        $sql = "INSERT INTO `klientai`(`vardas`, `pavarde`, `teises_id`, `imones_id`, `pridejimo_data`) VALUES ('$vardas','$pavarde',$teises_id, 0, '$pridejimo_data')";

        if(mysqli_query($prisijungimas, $sql)) {
            $message = "Vartotojas pridėtas sėkmingai";
            $class = 'success';
              echo 'Irasas yra pridetas';
              echo '<br>';
              echo 'Vardas:'.$vardas.'<br>'; 
              echo 'Pavarde:'.$pavarde.'<br>';
              echo 'Teises_id:'.$teises_id.'<br>';
              echo '<br>';
            //   echo 'Kliento vardas'.$_GET['vardas'],.'Kliento pavarde'.$_GET['pavarde'],.'teises_id'.$_GET['teises_id'];
            } else {
                $message =  "Kazkas ivyko negerai";
                $class = "danger";
        }
    } else {
        $message =  "Uzpildykite visus laukelius";
        $class = "danger";
    }
}
?>


<?php require_once("menu/includes.php"); ?>
<h1>Naujas klientas</h1>

<form action='klientupildymoforma.php' method='get'>
    <div class="form-group">
        <label for="vardas">Vardas:</label>
        <input class='form-control' type='text' name='vardas' placeholder='Iveskite Varda'/>
    </div>
    <div class="form-group">
    <label for="pavarde">Pavarde:</label>
    <input class='form-control' type='text' placeholder='Iveskite Pavarde' name='pavarde'/>
    </div> 
    <div class="form-group">
        <label for="teises_id">Teises:</label>
        <select class='form-control' name='teises_id' id='teises_id'>
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
<?php if(isset($message)) { ?>
                <div class="alert alert-<?php echo $class; ?>" role="alert">
                <?php echo $message; ?>
                </div>
            <?php } ?>


</div>





    
</body>
</html>



<?php 
// 1. Sukurti forma, kuri pagal ivestu duomenis issaugo duomenu bazes lenteleje Klientai
// 2. Papildyti dokumentą klientupildymoforma.php.
// *Po kliento pridėjimo, turi parodyti informaciją apie klientą. +
// *Tikrinti,ar teises_id laukelyje yra įvestas skaičius. +



?>