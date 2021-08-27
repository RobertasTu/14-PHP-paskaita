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
    echo "<button class='btn btn-primary' type='submit' name='klientai'>Klientų duomenų bazė</button>";
    echo "<button class='btn btn-primary' type='submit' name='imones'>Imonių duomenų bazė</button>";
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

<?php if ( $cookie_teises_id==1) { ?>
        <?php 
        if(isset($_GET['ID'])) {
          $id = $_GET['ID'];
          $sql = "DELETE FROM `vartotojai` WHERE `ID` = $id";

          if(mysqli_query($prisijungimas, $sql)) {
            $message = 'Vartotojas yra sekmingai istrintas';
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
<?php require_once("menu/includes.php"); ?>
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
<?php
  echo "<form action='vartotojai.php' method ='get'>";
  echo "<button class='btn btn-primary' type='submit' name='prideti'>Prideti nauja vartotoją</button>";
  if(isset($_GET['prideti'])) {
    header('Location: vartotojosukurimas.php');
  }
  ?>    
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
$sql = "SELECT vartotojai.ID, vartotojai.vardas, vartotojai.pavarde, vartotojai.slapyvardis, vartotojai.registracijos_data vartotojai_teises.pavadinimas FROM vartotojai
LEFT JOIN vartotojai_teises ON klientai_teises.pavadinimas = vartotojai.teises_id 
WHERE 1
ORDER BY vartotojai.ID $rikiavimas";

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $search = $_GET["search"];

  $sql = "SELECT vartotojai.ID, vartotojai.vardas, vartotojai.pavarde, vartotojai_teises.pavadinimas FROM vartotojai
  LEFT JOIN vartotojai_teises ON vartotojai_teises.pavadinimas = vartotojai.teises_id 

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
    echo '<tr>';
      echo '<td>'. $vartotojai['ID'].'</td>';
      echo '<td>'. $vartotojai['vardas'].'</td>';
      echo '<td>'. $vartotojai['pavarde'].'</td>';
      echo '<td>'. $vartotojai['pavadinimas'].'</td>';

//       $teises_id = $klientai["teises_id"];
//       $sql = "SELECT * FROM klientai_teises WHERE reiksme = $teises_id";
//       $rezultatas_teises = $prisijungimas->query($sql); //vykdoma uzklausa

//       if($rezultatas_teises->num_rows == 1) {
//           $teises = mysqli_fetch_array($rezultatas_teises);
//           echo "<td>";
//                echo $teises["pavadinimas"];
//           echo "</td>";
//       } else {
//           echo "<td>Nepatvirtintas klientas</td>";
//       }  
      
      echo '<td>';
        echo "<a href='klientoredagavimas.php?ID=".$vartotojai["ID"]."'>Redaguoti</a><br>"; 
        echo "<a href='klientai.php?ID=".$vartotojai["ID"]."'>Istrinti</a>";
      echo '</td>';
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

