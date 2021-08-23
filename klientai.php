<!-- 3. Sukurti dokumentą, klientai.php. Jame turi būti atvaizduojami visi klientai esantys duomenų bazėje.
4. Paspaudus ant kliento, turi būti įmanoma redaguoti jo duomenis ir išsaugoti.
5. Kiekvieną klientą turi būti galimybė ištrinti iš duomenų bazės. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select</title>
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
    echo "<form action='klientai.php' method ='get'>";
    echo "<button class='btn btn-primary' type='submit' name='logout'>Logout</button>";
    echo "</form>";
    if(isset($_GET["logout"])) {
        setcookie("prisijungti", "", time() - 3600, "/");
        header("Location: login.php");
    }
}    
?>
 


        <?php 
        if(isset($_GET['ID'])) {
          $id = $_GET['ID'];
          $sql = "DELETE FROM `klientai` WHERE `ID` = $id";

          if(mysqli_query($prisijungimas, $sql)) {
            $message = 'Klientas yra sekmingai istrintas';
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
  <h1>Klientai</h1>
    <table class="table">
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

  $sql = "SELECT * FROM `klientai` WHERE 1 ORDER BY `klientai`.`ID` DESC"; 
  $rezultatas = $prisijungimas->query($sql); 

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

      $teises_id = $klientai["teises_id"];
      $sql = "SELECT * FROM klientai_teises WHERE reiksme = $teises_id";
      $resultatas_teises = $prisijungimas->query($sql); //vykdoma uzklausa

      if($resultatas_teises->num_rows == 1) {
          $teises = mysqli_fetch_array($resultatas_teises);
          echo "<td>";
               echo $teises["pavadinimas"];
          echo "</td>";
      } else {
          echo "<td>Nepatvirtintas klientas</td>";
      }  
      
      echo '<td>';
        echo "<a href='klientoredagavimas.php?ID=".$klientai["ID"]."'>Redaguoti</a><br>"; 
        echo "<a href='klientai.php?ID=".$klientai["ID"]."'>Istrinti</a>";
      echo '</td>';
    echo '</tr>';
}
   



?>
 
  </tbody>
</table>
</div>

</div>

</body>
</html>

