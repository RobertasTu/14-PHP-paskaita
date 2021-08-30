<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imonės</title>
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
</head>

<body>

<?php 
require_once('connection.php');  
require_once("includes.php"); 
?>
<div class="container">
<?php 

if(!isset($_COOKIE["prisijungti"])) { 
    header("Location: login.php");    
} else {
    $cookie_text = $_COOKIE["prisijungti"];
    $cookie_array = explode("|", $cookie_text );
    $cookie_vardas = $cookie_array[1];
    echo "Sveikas prisijunges: ".$cookie_vardas;
    echo "<form action='imones.php' method ='get'>";
    // echo "<button class='btn btn-primary' type='submit' name='vartotojai'>Vartotojų duomenų bazė</button>";
    // echo "<button class='btn btn-primary' type='submit' name='klientai'>Klientų duomenų bazė</button>";
    echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    echo "</form>";
    if(isset($_GET['vartotojai'])) {
      header('Location: vartotojai.php');
    }
    if(isset($_GET['klientai'])) {
      header('Location: klientai.php');
    }

    if(isset($_GET["logout"])) {
        setcookie("prisijungti", "", time() - 3600, "/");
        header("Location: login.php");
    }
}    
?>
 
<?php 
    $cookie_text = $_COOKIE["prisijungti"];
    $cookie_array = explode("|", $cookie_text );

    $cookie_teises_id = $cookie_array[3];


    //KLientus gali matytyti tik administratorius

?>

<?php if ( $cookie_teises_id==1) { ?>
        <?php 
        if(isset($_GET['ID'])) {
          $id = $_GET['ID'];
          $sql = "DELETE FROM `imones` WHERE `ID` = $id";

          if(mysqli_query($prisijungimas, $sql)) {
            $message = 'Įmonė yra sėkmingai ištrinta';
              $class='pavyko';    
          } else {
            $message = 'Kažkas įvyko negerai';
                  $class='danger';  
            }     
        }

        ?>

                  <?php if(isset($message)) { ?>

                      <div class='alert alert-<?php echo $class; ?>' role='alert'>
                      <?php echo $message; ?>
                      </div>
                  <?php } ?>
<div class='container'>
<?php require_once("menu/includesim.php"); ?>
<?php if(isset($_GET["search"]) && !empty($_GET["search"])) { ?>
    <a class="btn btn-primary" href="imones.php"> Išvalyti paiešką</a>
<?php } ?>
  <h1>Įmonės</h1>

  <form action="imones.php" method="get">

<div class="form-group">
    <select class="form-control" name="rikiavimas_id">
        <option value="DESC"> Nuo didžiausio iki mažiausio</option>
        <option value="ASC"> Nuo mažiausio iki didžiausio</option>
    </select>
    <button class="btn btn-primary" name="rikiuoti" type="submit">Rikiuoti</button>
</div>

</form>
  <?php 
  echo "<form action='imones.php' method ='get'>";
  echo "<button class='btn btn-primary' type='submit' name='pridek_imone'>Pridėti naują įmonę</button>";
  echo "</form>";
    if(isset($_GET['pridek_imone'])) {
        header('Location: imonespildymoforma.php');
    } 
  ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Pavadinimas</th>
          <th scope="col">Aprašymas</th>
          <!-- <th scope="col">Tipas</th> -->
          <th scope="col">Veiksmai</th>
        </tr>
      </thead>
      <tbody>
  <?php

if(isset($_GET["rikiavimas_id"]) && !empty($_GET["rikiavimas_id"])) {
  $rikiavimas = $_GET["rikiavimas_id"];
} else {
  $rikiavimas = "DESC";
}
$sql = "SELECT imones.ID, imones.pavadinimas, imones.aprasymas, imones_tipas.aprasymas
FROM imones
LEFT JOIN imones_tipas
ON imones.tipas_ID = imones_tipas.ID  
WHERE 1
ORDER BY imones.ID $rikiavimas";

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $search = $_GET["search"];

  $sql = "SELECT imones.ID, imones.pavadinimas, imones.tipas_ID, imones.aprasas, imones_tipas.aprasymas 
  FROM imones
  LEFT JOIN imones_tipas ON imones.tipas_ID = imones_tipas.ID

  WHERE imones.pavadinimas LIKE '%".$search."%' OR imones.aprasas LIKE '%".$search."%' OR imones_tipas.aprasymas LIKE '%".$search."%'
  ORDER BY imones.ID $rikiavimas";
}

$rezultatas = $prisijungimas->query($sql);


  while($imones = mysqli_fetch_array($rezultatas)) {
    echo '<tr>';
      echo '<td>'. $imones['ID'].'</td>';
      echo '<td>'. $imones['pavadinimas'].'</td>';
      echo '<td>'. $imones['aprasymas'].'</td>';
      // echo '<td>'. $imones['aprasymas'].'</td>'; 

          
      echo '<td>';
        echo "<a href='imonesredagavimas.php?ID=".$imones["ID"]."'>Redaguoti</a><br>"; 
        echo "<a href='imones.php?ID=".$imones["ID"]."'>Istrinti</a>";
      echo '</td>';
    echo '</tr>';
}
   



?>
 
  </tbody>
</table>
</div>

</div>
<!-- <?php } else {
 echo 'Neturite prieigos';
}
?> -->
</body>