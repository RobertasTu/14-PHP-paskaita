<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vartotojai</title>
    <style>
        h1 {
            text-align: center;
        }

    
       
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
    echo "<form action='vartotojai.php' method ='get'>";
    // echo "<button class='btn btn-primary' type='submit' name='klientai'>Klientų duomenų bazė</button>";
    // echo "<button class='btn btn-primary' type='submit' name='imones'>Imonių duomenų bazė</button>";
    echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    echo "</form>";
    if(isset($_GET['klientai'])) {
      header('Location: klientai.php');
    }
    if(isset($_GET['imones'])) {
      header('Location: imones.php');
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


    //KLientus gali matyti tik administratorius

?>

<?php if ( $cookie_teises_id==1 || $cookie_teises_id==3 || $cookie_teises_id==4) { ?>
        <?php 
        if(isset($_GET['ID'])) {
          $id = $_GET['ID'];
          $sql = "DELETE FROM `vartotojai` WHERE `ID` = $id";

          if(mysqli_query($prisijungimas, $sql)) {
            $message = 'Vartotojas yra sekmingai ištrintas';
              $class='pavyko';    
          } else {
            $message = 'Kažkas įvyko negerai';
                  $class='danger';  
            }     
        }

        ?>

        <!-- <?php 
          if(isset($_GET['registracija.ID'])) {
          $id = $_GET['ID'];
          $registracija = 1;
          $sql = "UPDATE vartotojai
          SET registracija = $registracija
          WHERE ID = $id";

    if(mysqli_query($prisijungimas, $sql)) {
      $message = 'Registracija yra išjungta';
        $class='pavyko';

          } else {
            $message = 'Kažkas įvyko negerai';
                  $class='danger';  
            }  
            
          }
        
        ?> -->

                  <?php if(isset($message)) { ?>

                      <div class='alert alert-<?php echo $class; ?>' role='alert'>
                      <?php echo $message; ?>
                      </div>
                  <?php } ?>
<div class='container'>
<?php require_once("menu/includesvart.php"); ?>
<?php if(isset($_GET["search"]) && !empty($_GET["search"])) { ?>
    <a class="btn btn-primary" href="vartotojai.php"> Išvalyti paiešką</a>
<?php } ?>
  <h1>Vartotojai</h1>
 
  <form action="vartotojai.php" method="get">

<div class="form-group">
    <select class="form-control" name="rikiavimas_id">
        <option value="DESC"> Nuo didžiausio iki mažiausio</option>
        <option value="ASC"> Nuo mažiausio iki didžiausio</option>
    </select>
    <button class="btn btn-primary" name="rikiuoti" type="submit">Rikiuoti</button>
</div>

</form>

  
  <a href='vartotojosukurimas.php' class='btn btn-primary' name='prideti'>Prideti nauja vartotoją</a>
  
     
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Vardas</th>
          <th scope="col">Pavarde</th>
          <th scope="col">Slapyvardis</th>
          <th scope="col">Teises_ID</th>
          <th scope="col">Registracijos Data</th>
          <th scope="col">Paskutinis prisijungimas</th>
          <?php if($cookie_teises_id!=3) { ?>
          <th scope="col">Registracija</th>
          <th scope="col">Veiksmai</th>
          <?php } ?>
          



        </tr>
      </thead>
      <tbody>
  <?php

if(isset($_GET["rikiavimas_id"]) && !empty($_GET["rikiavimas_id"])) {
  $rikiavimas = $_GET["rikiavimas_id"];
} else {
  $rikiavimas = "DESC";
}
$sql = "SELECT vartotojai.ID, vartotojai.vardas, vartotojai.Registracija, vartotojai.pavarde, vartotojai.slapyvardis, vartotojai.teises_id, vartotojai.registracijos_data, vartotojai.paskutinis_prisijungimas, vartotojai_teises.pavadinimas FROM vartotojai
LEFT JOIN vartotojai_teises ON vartotojai.teises_id = vartotojai_teises.ID
WHERE 1
ORDER BY vartotojai.ID $rikiavimas";

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $search = $_GET["search"];

  $sql = "SELECT vartotojai.ID, vartotojai.vardas, vartotojai.pavarde, vartotojai_teises.pavadinimas FROM vartotojai
  LEFT JOIN vartotojai_teises ON vartotojai_teises.ID = vartotojai.teises_id 

  WHERE vartotojai.vardas LIKE '%".$search."%' OR vartotojai_teises.pavadinimas LIKE '%".$search."%'
  ORDER BY vartotojai.ID $rikiavimas";
}




$rezultatas = $prisijungimas->query($sql);

  // $sql = "SELECT * FROM `klientai` WHERE 1 ORDER BY `klientai`.`ID` DESC"; 
  // $rezultatas = $prisijungimas->query($sql); 
// 
  //ID pavadinimas aprasymas
  //1  admin       administratorius
  // 2  vadyb       vadybininkas
  // 3  inspekt     inspektorius
  // 4  s_admin     sistemos administratorius

  
  while($vartotojai = mysqli_fetch_array($rezultatas)) {
    switch ($vartotojai['Registracija']) { // 0 ir 1
      case '0':
        $kintamasis = "Įjungta";
        break;
        case '1';
        $kintamasis = 'Išjungta';
        break;
        
    }
    echo '<tr>';
      echo '<td>'. $vartotojai['ID'].'</td>';
      echo '<td>'. $vartotojai['vardas'].'</td>';
      echo '<td>'. $vartotojai['pavarde'].'</td>';
      echo '<td>'. $vartotojai['slapyvardis'].'</td>';
      echo '<td>'. $vartotojai['pavadinimas'].'</td>';
      echo '<td>'. $vartotojai['registracijos_data'].'</td>';
      echo '<td>'. $vartotojai['paskutinis_prisijungimas'].'</td>';
      if($cookie_teises_id!=3) {
      echo '<td>'. $kintamasis.'</td>';
                  
      
     
      
      echo '<td>';
      if($cookie_teises_id!=4) {
        echo "<a href='vartotojoredagavimas.php?ID=".$vartotojai["ID"]."'>Redaguoti</a><br>"; 
      }
        echo "<a href='vartotojai.php?ID=".$vartotojai["ID"]."'>Ištrinti</a>";
        
      echo '</td>';
      }    

    echo '</tr>';
}
   



?>
 
  </tbody>
</table>
</div>

</div>
 <?php } else {
 echo 'Neturite prieigos';
}
?>
</body>
</html>

