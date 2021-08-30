<?php 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Įmonės redagavimas</title>

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
    $sql = "SELECT * FROM `imones` WHERE ID = $id"; 

    $rezultatas = $prisijungimas->query($sql);

    if($rezultatas->num_rows == 1) {

        $imones = mysqli_fetch_array($rezultatas);
        $hideForm = false;
    
    } else {
        $hideForm = true;
        // header('klientai.php');
    }

}

if(isset($_GET["submit"])) {
    if(isset($_GET["pavadinimas"]) && isset($_GET["aprasymas"]) && isset($_GET["tipas_ID"]) && !empty($_GET["pavadinimas"]) && !empty($_GET["aprasymas"]) && !empty($_GET["tipas_ID"])) {
        $id = $_GET["ID"];
        $pavadinimas = $_GET["pavadinimas"];
        $aprasymas = $_GET["aprasymas"];
        $tipas_id = intval($_GET["tipas_ID"]);

        $sql = "UPDATE `imones` 
        SET `pavadinimas`='$pavadinimas',`aprasymas`='$aprasymas',`tipas_ID`=$tipas_id 
        WHERE ID = $id";

        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Įmonė redaguota sėkmingai";
            $class = "success";
            echo $pavadinimas;
            echo $aprasymas;
            echo $tipas_id;
        } else {
            $message =  "Kažkas ivyko negerai";
            $class = "danger";
        }
    } else {
        $id = $imones["ID"];
        $pavadinimas = $imones["pavadinimas"];
        $aprasymas = $imones["aprasymas"];
        $tipas_id = intval($imones["tipas_ID"]);

        $sql = "UPDATE `imones`
        SET `pavadinimas`='$pavadinimas',`aprasymas`='$aprasymas',`tipas_ID`=$tipas_id
        WHERE ID = $id";
        if(mysqli_query($prisijungimas, $sql)) {
            $message =  "Įmonė redaguota sėkmingai";
            $class = "success";
        } else {
            $message =  "Kažkas ivyko negerai";
            $class = "danger";
        }
    }
}


?>


<div class='container'>
    <h1>Įmonės redagavimas</h1>

    <?php if($hideForm == false) { ?>

   
 <form action='imonesredagavimas.php' method='get'>

    <input class="hide" type="text" name="ID" value ="<?php echo $imones['ID']; ?>" />

 <div class='form-group'>
        <label for='pavadinimas'>Pavadinimas</label>
        <input  class='form-control' required='true' type='text' name='pavadinimas' value="<?php echo $imones['pavadinimas']; ?>" />
</div>
<div class='form-group'>
        <label for='aprasymas'>Aprasymas</label>
        <input class='form-control' type='text' required='true' name='aprasymas'  value="<?php echo $imones['aprasymas']; ?>" />
</div>
<div class='form-group'>
        <label for='tipas_id'>Tipas</label>
        <!-- <input type='text' name='teises_id' required='true' value="<?php $imones['tipas_id']; ?>" /> -->
                    <select class='form-control' name='tipas_ID' id='tipas_ID'>
                        <?php 
                         $sql = "SELECT * FROM imones_tipas";
                         $rezultatas = $prisijungimas->query($sql);
                     
                         while($imones_tipas = mysqli_fetch_array($rezultatas)) {

                            if($tipas_ID == $imones_tipas["ID"] ) {
                                echo "<option value='".$imones_tipas["ID"]."' selected='true'>";
                            }  else {
                                echo "<option value='".$imones_tipas["ID"]."'>";
                            }  
                                
                                echo $imones_tipas["aprasymas"];
                            echo "</option>";
                        }
                        ?>
                    </select>
    </div>

<a href='imones.php'>Atgal</a><br>
<button class='btn btn-primary' type='submit' name='submit'>Issaugoti naujus duomenis</button>
   
</form>
    <?php if(isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>

<?php } else { ?>
    <h2>Tokio įmonės nera</h2>
    <a href='imones.php'>Atgal</a>

    <?php } ?>

</div>


    
</body>
</html>

