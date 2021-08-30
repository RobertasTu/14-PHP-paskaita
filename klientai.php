<!-- 3. Sukurti dokumentą, klientai.php. Jame turi būti atvaizduojami visi klientai esantys duomenų bazėje.
4. Paspaudus ant kliento, turi būti įmanoma redaguoti jo duomenis ir išsaugoti.
5. Kiekvieną klientą turi būti galimybė ištrinti iš duomenų bazės. -->
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klientai</title>
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
    echo "<form action='klientai.php' method ='get'>";
    // echo "<button class='btn btn-primary' type='submit' name='vartotojai'>Vartotojų duomenų bazė</button>";
    // echo "<button class='btn btn-primary' type='submit' name='imones'>Imonių duomenų bazė</button>";
    echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    echo "</form>";
    if(isset($_GET['vartotojai'])) {
      header('Location: vartotojai.php');
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
          $sql = "DELETE FROM `klientai` WHERE `ID` = $id";

          if(mysqli_query($prisijungimas, $sql)) {
            $message = 'Klientas yra sėkmingai ištrintas';
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
<?php require_once("menu/includes.php"); ?>
<?php if(isset($_GET["search"]) && !empty($_GET["search"])) { ?>
    <a class="btn btn-primary" href="klientai.php"> Išvalyti paiešką</a>
<?php } ?>
  <h1>Klientai</h1>
 
  <form action="klientai.php" method="get">

<div class="form-group">
    <select class="form-control" name="rikiavimas_id">
        <option value="DESC"> Nuo didžiausio iki mažiausio</option>
        <option value="ASC"> Nuo mažiausio iki didžiausio</option>
    </select>
    <button class="btn btn-primary" name="rikiuoti" type="submit">Rikiuoti</button>
</div>

</form>

<a href="klientupildymoforma.php" class="btn btn-primary">Prideti nauja klienta</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Vardas</th>
          <th scope="col">Pavarde</th>
          <th scope="col">Teises</th>
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
$sql = "SELECT klientai.ID, klientai.vardas, klientai.pavarde, klientai_teises.pavadinimas
FROM klientai
LEFT JOIN klientai_teises ON klientai_teises.reiksme = klientai.teises_id 
WHERE 1
ORDER BY klientai.ID $rikiavimas";

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $search = $_GET["search"];

  $sql = "SELECT klientai.ID, klientai.vardas, klientai.pavarde, klientai_teises.pavadinimas FROM klientai
  LEFT JOIN klientai_teises ON klientai_teises.reiksme = klientai.teises_id 

  WHERE klientai.vardas LIKE '%".$search."%' OR klientai_teises.pavadinimas LIKE '%".$search."%'
  ORDER BY klientai.ID $rikiavimas";
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

  
  while($klientai = mysqli_fetch_array($rezultatas)) {
    echo '<tr>';
      echo '<td>'. $klientai['ID'].'</td>';
      echo '<td>'. $klientai['vardas'].'</td>';
      echo '<td>'. $klientai['pavarde'].'</td>';
      echo '<td>'. $klientai['pavadinimas'].'</td>';

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
        echo "<a href='klientoredagavimas.php?ID=".$klientai["ID"]."'>Redaguoti</a><br>"; 
        echo "<a href='klientai.php?ID=".$klientai["ID"]."'>Ištrinti</a>";
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

