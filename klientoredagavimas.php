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

<?php 

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
        $teises_id = intval($_GET["teises_id"]);

        $sql = "UPDATE `klientai` SET `vardas`='$vardas',`pavarde`='$pavarde',`teises_id`=$teises_id WHERE ID = $id";

        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Vartotojas redaguotas sėkmingai";
            $class = "success";
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    } else {
        $id = $klientas["ID"];
        $vardas = $klientas["vardas"];
        $pavarde = $klientas["pavarde"];
        $teises_id = intval($klientas["teises_id"]);

        $sql = "UPDATE `klientai` SET `vardas`='$vardas',`pavarde`='$pavarde',`teises_id`=$teises_id WHERE ID = $id";
        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Vartotojas redaguotas sėkmingai";
            $class = "success";
        } else {
            $message =  "Kazkas ivyko negerai";
            $class = "danger";
        }
    }
}


?>


<div class='container'>
    <h1>Kliento redagavimas</h1>

    <?php if($hideForm == false) { ?>

   
 <form action='klientoredagavimas.php' method='get'>

    <input class="hide" type="text" name="ID" value ="<?php echo $klientas['ID']; ?>" />

 <div class='form-group'>
        <label for='vardas'>Vardas</label>
        <input  class='form-control' type='text' name='vardas' value="<?php echo $klientas['vardas']; ?>" />
</div>
<div class='form-group'>
        <label for='pavarde'>Pavarde</label>
        <input class='form-control' type='text' name='pavarde'  value="<?php echo $klientas['pavarde']; ?>" />
</div>
<div class='form-group'>
        <label for='teises_id'>Teises_id</label>
        <!-- <input type='text' name='teises_id' required='true' value="<?php $klientas['teises_id']; ?>" /> -->
                    <select class="form-control" name="teises_id">
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



