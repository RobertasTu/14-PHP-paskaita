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
    echo "Sveikas prisijunges";
    echo "<form action='imones.php' method ='get'>";
    echo "<button class='btn btn-primary' type='submit' name='vartotojai'>Vartotojų duomenų bazė</button>";
    echo "<button class='btn btn-primary' type='submit' name='klientai'>Klientų duomenų bazė</button>";
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

<!-- <?php if ( $cookie_teises_id==1) { ?> -->
        <?php 
        if(isset($_GET['ID'])) {
          $id = $_GET['ID'];
          $sql = "DELETE FROM `imones` WHERE `ID` = $id";

          if(mysqli_query($prisijungimas, $sql)) {
            $message = 'Įmonė yra sekmingai istrinta';
              $class='pavyko';    
          } else {
            $message = 'Kazkas ivyko negerai';
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
  <h1>Imones</h1>
  <?php 
  echo "<form action='imones.php' method ='get'>";
  echo "<button class='btn btn-primary' type='submit' name='pridek_imone'>Pridėti naują įmonę</button>";
  echo "</form>";
    if(isset($_GET['pridek_imone'])) {
        header('Location: imonespildymoforma.php');
    } 
  ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Pavadinimas</th>
          <th scope="col">Tipas_ID</th>
          <th scope="col">Aprasymas</th>
          <th scope="col">Veiksmai</th>
        </tr>
      </thead>
      <tbody>
  <?php

  $sql = "SELECT * FROM `imones` WHERE 1 ORDER BY `imones`.`ID` DESC"; 
  $rezultatas = $prisijungimas->query($sql); 
                 
  //ID pavadinimas aprasymas
  //1  admin       administratorius
  // 2  vadyb       vadybininkas
  // 3  inspekt     inspektorius
  // 4  s_admin     sistemos administratorius

  
  while($imones = mysqli_fetch_array($rezultatas)) {
    echo '<tr>';
      echo '<td>'. $imones['ID'].'</td>';
      echo '<td>'. $imones['pavadinimas'].'</td>';

      $imonestipas_ID = $imones_tipas['pavadinimas'];
      $sql = "SELECT * FROM imones_tipas WHERE reiksme = $imonestipas_ID";
      $rezultatas_tipasID = $prisijungimas->query($sql);

      if($rezultatas_tipasID->num_rows == 1) {
        $imonestipas = mysqli_fetch_array($rezultatas_tipasID);
        echo '<td>';
          echo $imonestipas['pavadinimas'];
          echo '<td>';

      } else {
        echo "<td>Nepatvirtinta imone</td>";
      }
      // echo '<td>'. $imones['tipas_ID'].'</td>';
      echo '<td>'. $imones['aprasymas'].'</td>';     
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