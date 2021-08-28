<?php 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vartotojo sukūrimo forma</title>

    <?php require_once('includes.php'); ?>
    
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
    if(isset($_GET['vardas']) && !empty($_GET['vardas']) && isset($_GET['pavarde']) && !empty($_GET['pavarde']) && isset($_GET['slapyvardis']) && !empty($_GET['slapyvardis'])  && isset($_GET['slaptazodis']) && !empty($_GET['slaptazodis']) && isset($_GET['registracijos_data']) && isset($_GET['teises_id']) && !empty($_GET['teises_id'])) {
        $vardas = $_GET['vardas'];
        $pavarde = $_GET['pavarde'];
        $slapyvardis = $_GET['slapyvardis'];
        $slaptazodis = $_GET['slaptazodis'];
        $registracijos_data = $_GET['registracijos_data'];
        $teises_id = intval($_GET['teises_id']);
        $paskutinis_prisijungimas = $registracijos_data;

        
        
        $sql = "INSERT INTO `vartotojai`(`vardas`, `pavarde`, `slapyvardis`, `teises_id`, `slaptazodis`, `registracijos_data`, `paskutinis_prisijungimas`) VALUES ('$vardas','$pavarde','$slapyvardis', '$teises_id', '$slaptazodis','2021-08-28','2021-08-28')";
        if(mysqli_query($prisijungimas, $sql)) {
            $message = "Vartotojas pridėtas sėkmingai";
            $class = 'success';
                       
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


<div class='container'>
<?php require_once("menu/includesvart.php"); ?>

<h1>Naujas Vartotojas</h1>
    <form action='vartotojosukurimas.php' method='get'>
    
<div class="form-group">
    <label for="vardas">Vardas:</label>
    <input class='form-control' type='text' name='vardas' placeholder='Iveskite Varda '/>
</div>
<div class="form-group">
    <label for="pavarde">Pavarde:</label>
    <input class='form-control' type='text' placeholder='Iveskite Pavarde ' name='pavarde'/>
 </div> 
 <div class="form-group">
    <label for="slapyvardis">Slapyvardis:</label>   
    <input class='form-control' type='text' placeholder='Iveskite slapyvardi' name='slapyvardis'/>
</div>
<div class="form-group">
    <label for="slaptazodis">Slaptazodis:</label>
    <input class='form-control' type='text' placeholder='Iveskite slaptazodi' name='slaptazodis'/>
</div>
<div class="form-group">
    <label for="data">Data:</label>
    <?php echo date("Y.m.d") ?>
    <input  class='form-control' type='date' value='<?php echo date("Y.m.d") ?>' name='registracijos_data' hidden='true'/>
</div>

<div class="form-group">
    <label for="teises_id">Teises:</label>
    <select class='form-control' name='teises_id' id='teises_id'>
    <?php 
                         $sql = "SELECT * FROM vartotojai_teises";
                         $rezultatas = $prisijungimas->query($sql);
                     
                         while($vartotojaiTeises = mysqli_fetch_array($rezultatas)) {

                            if($vartotojai["teises_id"] == $vartotojaiTeises["reiksme"] ) {
                                echo "<option value='".$vartotojaiTeises["reiksme"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$vartotojaiTeises["reiksme"]."'>";
                            }  
                                
                                echo $vartotojaiTeises["pavadinimas"];
                            echo "</option>";
                        }
                        ?>
    </select>


    <button class='btn btn-primary' type='submit' name='prideti'>Prideti nauja vartotoją</button>
    <a href='vartotojai.php'>Atgal</a>

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