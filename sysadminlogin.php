<?php 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemų administratoriaus puslapis</title>

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

        .buttons {
            display: flex;
            justify-content: center;
            span: 150px;
            
            
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
    $cookie_id = $cookie_array[0];
    $date = date("Y-m-d");
    echo "Sveikas prisijunges: ".$cookie_vardas;
    echo "<form action='adminlogin.php' method ='get'>";
    echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    echo "</form>";
    echo $date.'<br>';
    // echo 'Vartotojo_id: '.$cookie_id;

    
    $sql = "UPDATE `vartotojai`
    SET `paskutinis_prisijungimas` = '$date'
    WHERE ID = $cookie_id";
    $rezultatas = $prisijungimas->query($sql);

   

    if(isset($_GET["logout"])) {
        setcookie("prisijungti", "", time() - 3600, "/");
        header("Location: login.php");
    }
}  
    ?>

    <h1>Sistemų administratoriaus puslapis</h1>
    <form action='adminlogin.php' method='get'>
    <div class='buttons'>
    <button class='btn btn-primary' type='submit' name='vartotojai'>Vartotojai</button>
    <button class='btn btn-primary' type='submit' name='klientai'>Klientai</button>
    <button class='btn btn-primary' type='submit' name='imones'>Įmonės</button>
    </div>
    </form>

    </div>

    <?php 

    
    
    if(isset($_GET['klientai'])) {
        header('Location: klientai.php');
    }

    if(isset($_GET['vartotojai'])) {
        header('Location: vartotojai.php');
    }
    if(isset($_GET['imones'])) {
        header('Location: imones.php');
    }

    
    ?>


    </body>


    </html>