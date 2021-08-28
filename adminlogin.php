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

        .buttons {
            display: flex;
            justify-content: center;
            span: 150px;
            
            
        }
    </style>

</head>

<body>
<div class='container'>
    <h1>Administratoriaus puslapis</h1>
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
    
    ?>


    </body>


    </html>