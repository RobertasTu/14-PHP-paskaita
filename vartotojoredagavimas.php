<?php 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vartotojo redagavimas</title>

    <?php require_once("includes.php"); ?>
    
    <style>
        h1 {
            text-align: center;
        }

        .container {
            position:absolute;
            top:50%;
            left:50%;
            transform: translateY(-50%) translateX(-50%);
        }

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

if(isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $sql = "SELECT * FROM `vartotojai` WHERE ID = $id"; 

    $rezultatas = $prisijungimas->query($sql);

    if($rezultatas->num_rows == 1) {

        $vartotojai = mysqli_fetch_array($rezultatas);
        $hideForm = false;
    
    } else {
        $hideForm = true;
        // header('klientai.php');
    }

}

if(isset($_GET["submit"])) {
    // if(isset($_GET["vardas"]) && isset($_GET["pavarde"]) && isset($_GET["teises_id"]) && !empty($_GET["vardas"]) && !empty($_GET["pavarde"]) && isset($_GET["slapyvardis"]) && !empty($_GET['slapyvardis'])) {
        $id = $_GET["ID"];
        $vardas = $_GET["vardas"];
        $pavarde = $_GET["pavarde"];
        $teises_id = intval($_GET["teises_id"]);
        $slapyvardis = $_GET["slapyvardis"];
        $slaptazodis = $_GET["slaptazodis"];
        $registracija = $_GET['registracija'];


        $sql = "UPDATE `vartotojai`
        SET `vardas`='$vardas', `pavarde`='$pavarde', `slapyvardis`='$slapyvardis', `teises_id`=$teises_id, `slaptazodis`='$slaptazodis', `Registracija`='$registracija'
        WHERE ID = $id";

        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Vartotojas redaguotas sėkmingai";
            $class = "success";
            // echo 'teises_id: '.$teises_id;
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    } else {
        $id = $vartotojai["ID"];
        $vardas = $vartotojai["vardas"];
        $pavarde = $vartotojai["pavarde"];
        $slapyvardis = $vartotojai["slapyvardis"];
        $slaptazodis= $vartotojai["slaptazodis"];
        $teises_id = intval($vartotojai["teises_id"]);

        $sql = "UPDATE `vartotojai`
        SET `vardas`='$vardas', 'pavarde'='$pavarde'
        WHERE ID = $id";
        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Vartotojas redaguotas sėkmingai";
            $class = "success";
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    }

// }


?>

<?php require_once("menu/includesvart.php"); ?>

    <h1>Vartotojo redagavimas</h1>

    <?php if($hideForm == false) { ?>

   
 <form action='vartotojoredagavimas.php' method='get'>

    <input class="hide" type="text" name="ID" value ="<?php echo $vartotojai['ID']; ?>" />

 <div class='form-group'>
        <label for='vardas'>Vardas</label>
        <input  class='form-control' type='text' name='vardas' value="<?php echo $vartotojai['vardas']; ?>" />
</div>
<div class='form-group'>
        <label for='pavarde'>Pavarde</label>
        <input class='form-control' type='text' name='pavarde'  value="<?php echo $vartotojai['pavarde']; ?>" />
</div>
<div class='form-group'>
        <label for='slapyvardis'>Slapyvardis</label>
        <input class='form-control' type='text' name='slapyvardis'  value="<?php echo $vartotojai['slapyvardis']; ?>" />
</div>
<div class='form-group'>
        <label for='teises_id'>Teises_id</label>
        <!-- <input type='text' name='teises_id' required='true' value="<?php $vartotojai['teises_id']; ?>" /> -->
                    <select class="form-control" name="teises_id">
                        <?php 
                         $sql = "SELECT * FROM vartotojai_teises";
                         $rezultatas = $prisijungimas->query($sql);
                     
                         while($vartotojai_teises = mysqli_fetch_array($rezultatas)) {

                            if($teises_id == $vartotojai_teises["ID"] ) {
                                echo "<option value='".$vartotojai_teises["ID"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$vartotojai_teises["ID"]."'>";
                            }  
                                
                                echo $vartotojai_teises["aprasymas"];
                            echo "</option>";
                        }
                        ?>
                    </select>
    </div>
    <div class='form-group'>
        <label for='slaptazodis'>Slaptazodis</label>
        <input class='form-control' type='text' name='slaptazodis'  value="<?php echo $vartotojai['slaptazodis']; ?>" />
</div>
<div class='form-group'>
        <label for='registracija'>Registracija</label>
        <select class="form-control" name="registracija">
        <option value="0">Vartojojo registracija įjungta</option>
        <option value="1">Vartotojo registracija išjungta</option> 
            
            </select>

<a href='vartotojai.php'>Atgal</a><br>
<button class='btn btn-primary' type='submit' name='submit'>Issaugoti naujus duomenis</button>
   
</form>
    <?php if(isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>

<?php } else { ?>
    <h2>Tokio vartotojo nera</h2>
    <a href='vartotojai.php'>Atgal</a>

    <?php } ?>

</div>


    
</body>
</html>
