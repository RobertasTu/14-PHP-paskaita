<?php 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kliento redagavimas</title>

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

// $teises_id=0;

if(isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $sql = "SELECT * FROM `klientai` WHERE ID = $id"; 

    $rezultatas = $prisijungimas->query($sql);

    if($rezultatas->num_rows == 1) {

        $klientas = mysqli_fetch_array($rezultatas);
        $hideForm = false;
    
    } else {
        $hideForm = true;
        // header('klientai.php');
    }

}

if(isset($_GET["submit"])) {
    if(isset($_GET["vardas"]) && isset($_GET["pavarde"]) && isset($_GET["teises_id"]) && !empty($_GET["vardas"]) && !empty($_GET["pavarde"]) && !empty($_GET["teises_id"])) {
        $id = $_GET["ID"];
        $vardas = $_GET["vardas"];
        $pavarde = $_GET["pavarde"];
        $teises_id = $_GET["teises_id"];

        $sql = "UPDATE `klientai` 
        SET `vardas`='$vardas',`pavarde`='$pavarde',`teises_id`=$teises_id 
        WHERE ID = $id";

        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Klientas redaguotas sėkmingai";
            $class = "success";
            echo $vardas;
            echo $pavarde;
            echo $teises_id;

        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    } else {
        $id = $klientas["ID"];
        $vardas = $klientas["vardas"];
        $pavarde = $klientas["pavarde"];
        $teises_id = $klientas["teises_id"];

        $sql = "UPDATE `klientai`
        SET `vardas`='$vardas',`pavarde`='$pavarde',`teises_id`=$teises_id
        WHERE ID = $id";
        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Klientas redaguotas sėkmingai";
            $class = "success";
            echo $vardas;
            echo $pavarde;
            echo $teises_id;
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    }
}


?>


<?php require_once("menu/includes.php"); ?>
    <h1>Kliento redagavimas</h1>

    <?php if($hideForm == false) { ?>

   
 <form action='klientoredagavimas.php' method='get'>

    <input class="hide" type="text" name="ID" value ="<?php echo $klientas['ID']; ?>" />

 <div class='form-group'>
        <label for='vardas'>Vardas</label>
        <input  class='form-control' required='true' type='text' name='vardas' value="<?php echo $klientas['vardas']; ?>" />
</div>
<div class='form-group'>
        <label for='pavarde'>Pavarde</label>
        <input class='form-control' type='text' required='true' name='pavarde'  value="<?php echo $klientas['pavarde']; ?>" />
</div>
<div class='form-group'>
        <label for='teises_id'>Teises_id</label>
        <!-- <input type='text' name='teises_id' required='true' value="<?php $klientas['teises_id']; ?>" /> -->
                    <select class="form-control" name="teises_id">
                        <?php 
                         $sql = "SELECT * FROM klientai_teises";
                         $rezultatas = $prisijungimas->query($sql);
                     
                         while($klientai_teises = mysqli_fetch_array($rezultatas)) {

                            if($klientas['teises_id']== $klientai_teises["reiksme"] ) {
                                echo "<option value='".$klientai_teises["reiksme"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$klientai_teises["reiksme"]."'>";
                            }  
                                
                                echo $klientai_teises["pavadinimas"];
                            echo "</option>";
                        }
                        ?>
                    </select>
    </div>

<a href='klientai.php'>Atgal</a><br>
<button class='btn btn-primary' type='submit' name='submit'>Issaugoti naujus duomenis</button>
   
</form>
    <?php if(isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>

<?php } else { ?>
    <h2>Tokio kliento nera</h2>
    <a href='klientai.php'>Atgal</a>

    <?php } ?>

</div>


    
</body>
</html>



