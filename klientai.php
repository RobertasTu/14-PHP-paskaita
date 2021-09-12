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

<?php if ( $cookie_teises_id==1 || $cookie_teises_id==2  || $cookie_teises_id==3 || $cookie_teises_id==4) { ?>
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

  <div class="row">
  <div class="col-lg-12 col-md-12">
        <h3>Filtravimas ir rikiavimas</h3>
 
  <form action="klientai.php" method="get">

    <div class="form-group">

        <select class="form-control" name="rikiuoti_pagal">
      <?php
            $sql = "SELECT * FROM `klientai_rikiavimas`";

            $rezultatas = $prisijungimas->query($sql); //vykdoma uzklausa

            $rikiavimo_stulpelis = array();
            $skaitiklis = 1;
            while($sortColumns = mysqli_fetch_array($rezultatas)) {
           if($skaitiklis == 1) {
            $numatytoji_reiksme = $sortColumns["ID"]; //paskutine reiksme
           }             
              
              if(isset($_GET["rikiuoti_pagal"]) && $_GET["rikiuoti_pagal"] == $sortColumns["ID"]) {
                  echo "<option value='".$sortColumns["ID"]."' selected='true'>".$sortColumns["rikiavimo_pavadinimas"]."</option>";
              } else {
                  echo "<option value='".$sortColumns["ID"]."'>".$sortColumns["rikiavimo_pavadinimas"]."</option>";    
              }
              
              $rikiavimo_stulpelis[$sortColumns["ID"]] =  $sortColumns["rikiavimo_stulpelis"];
              
              $skaitiklis++;
          }            
      ?>
      </select>
      
      <select class="form-control" name="rikiavimas_id">
          <?php if((isset($_GET["rikiavimas_id"]) && $_GET["rikiavimas_id"] == "DESC") || !isset($_GET["rikiavimas_id"]) ) {  ?>
              <option value="DESC" selected='true'> Nuo didžiausio iki mažiausio</option>
              <option value="ASC"> Nuo mažiausio iki didžiausio</option>
              <?php } else {?>
                        <option value="DESC"> Nuo didžiausio iki mažiausio</option>
                        <option value="ASC" selected="true"> Nuo mažiausio iki didžiausio</option>
               <?php } ?> 
    </select>
    <select class="form-control" name="filtravimas_id">          
    <?php if(isset($_GET["filtravimas_id"]) && !empty($_GET["filtravimas_id"]) && $_GET["filtravimas_id"] != "default") {?>
                <option value="default">Rodyti visus</option>
<?php } else {?>
                <option value="default" selected="true">Rodyti visus</option>
<?php } ?>  
<?php 
                         $sql = "SELECT * FROM klientai_teises";
                         $rezultatas = $prisijungimas->query($sql);

                         while($clientRights = mysqli_fetch_array($rezultatas)) {
                            if(isset($_GET["filtravimas_id"]) && $_GET["filtravimas_id"] == $clientRights["reiksme"] ) {
                                echo "<option value='".$clientRights["reiksme"]."' selected='true'>";
                            } else  {
                                echo "<option value='".$clientRights["reiksme"]."'>";
                            }
                                echo $clientRights["pavadinimas"];
                            echo "</option>";
                        }
                        ?>
                        </select>


    <button class="btn btn-primary" name="filtruoti" type="submit">Vykdyti</button>
</div>

</form>
<?php   if(isset($_GET["filtravimas_id"]) && !empty($_GET["filtravimas_id"]) && $_GET["filtravimas_id"] != "default") { ?>
            <a class="btn btn-primary" href="klientai.php">Išvalyti filtrą</a>
        <?php } ?>


<?php if($cookie_teises_id!=3) { ?>
<a href="klientupildymoforma.php" class="btn btn-primary">Prideti nauja klienta</a>
  <?php } ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Vardas</th>
          <th scope="col">Pavarde</th>
          <th scope="col">Teises</th>
          <?php if($cookie_teises_id!=3) { ?>
          <th scope="col">Veiksmai</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
      
  <?php 
    $clients_count = 30;
    $pagination_url = "";        

    if(isset($_GET["page-limit"])) {
        $page_limit = $_GET["page-limit"] * $clients_count - $clients_count;    
    } else {
        $page_limit = 0;    
    }        

    if(isset($_GET["rikiuoti_pagal"]) && !empty($_GET["rikiuoti_pagal"])) {
      $rikiuoti_pagal = $rikiavimo_stulpelis[$_GET["rikiuoti_pagal"]];
      $pagination_url .= "&rikiuoti_pagal=". $_GET["rikiuoti_pagal"];
 } else {
      $rikiuoti_pagal = $rikiavimo_stulpelis[$numatytoji_reiksme];
 }


  if(isset($_GET['filtravimas_id']) && !empty($_GET['filtravimas_id']) && $_GET['filtravimas_id'] !='default') {
    $filtravimas = 'klientai.teises_id ='.$_GET['filtravimas_id'];
    $pagination_url .= "&filtravimas_id=". $_GET["filtravimas_id"];
     } else {
       $filtravimas = 1;
     }

if(isset($_GET["rikiavimas_id"]) && !empty($_GET["rikiavimas_id"]) && isset($_GET["page-limit"])) {
  $rikiavimas = $_GET["rikiavimas_id"];
  $pagination_url .= "&rikiavimas_id=". $_GET["rikiavimas_id"];
} else {
  $rikiavimas = "DESC";
 
}

$sql = "SELECT klientai.ID, klientai.vardas, klientai.pavarde, klientai_teises.pavadinimas
FROM klientai
LEFT JOIN klientai_teises ON klientai_teises.reiksme = klientai.teises_id 
WHERE $filtravimas
ORDER BY $rikiuoti_pagal $rikiavimas
LIMIT $page_limit , $clients_count
";

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $search = $_GET["search"];

  $sql = "SELECT klientai.ID, klientai.vardas, klientai.pavarde, klientai_teises.pavadinimas FROM klientai
  LEFT JOIN klientai_teises ON klientai_teises.reiksme = klientai.teises_id 

  WHERE klientai.vardas LIKE '%".$search."%' OR klientai.pavarde
  LIKE '%".$search."%' AND $filtravimas
  ORDER BY $rikiuoti_pagal $rikiavimas
  LIMIT $page_limit , $clients_count 
  ";
}



// if(isset($_GET["page-limit"])) {
//     $page_limit = $_GET["page-limit"] * 30 - 30;    
// } else {
//     $page_limit = 0;    
// }

// $sql = "SELECT * FROM 
// klientai
// ORDER BY klientai.ID ASC
// LIMIT $page_limit , 30
// ";


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
if($cookie_teises_id!=3) {
      echo '<td>';
      
        echo "<a href='klientoredagavimas.php?ID=".$klientai["ID"]."'>Redaguoti</a><br>"; 
        echo "<a href='klientai.php?ID=".$klientai["ID"]."'>Ištrinti</a>";
      
      echo '</td>';
}
    echo '</tr>';
}


   



?>

 
  </tbody>
</table>

<?php

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $page_filtering = "klientai.vardas LIKE '%".$search."%' OR klientai.pavarde 
  LIKE '%".$search."%' AND $filtravimas";
} else {
  $page_filtering = $filtravimas;
}


$sql = "SELECT CEILING(COUNT(ID)/$clients_count) AS puslapiu_skaicius, COUNT(ID) AS viso_klientai 
FROM klientai
WHERE $page_filtering
";



$rezultatas = $prisijungimas->query($sql);  
//Kiek irasu grazina sita uzklausa?
//1 irasas
if($rezultatas->num_rows == 1) { 
    $clients_total_pages = mysqli_fetch_array($rezultatas);
    // var_dump($clients_total_pages);
    
    for($i = 1; $i <= intval($clients_total_pages['puslapiu_skaicius']); $i++) {

      if(!isset($_GET["page-limit"]) && $i==1) {
        //Ar tikrai mes $i turim perduot?
        echo "<a class='btn btn-primary' href='klientai.php?page-limit=$i$pagination_url'>";
      } else if((isset($_GET["page-limit"]) && $_GET["page-limit"] == $i) )
      {
        echo "<a class='btn btn-primary active' href='klientai.php?page-limit=$i$pagination_url'>";
      } else {
        echo "<a class='btn btn-primary' href='klientai.php?page-limit=$i$pagination_url'>";
      }
            echo $i; //puslapio numeris
            echo " ";
        echo "</a>";
    }
    
    echo "<p>";
    echo "Iš viso puslapių: ";
    echo $clients_total_pages['puslapiu_skaicius'];
    echo "</p>";

    echo "<p>";
    if (isset($_GET["page-limit"])) {
        echo $_GET["page-limit"];
    } else {
        echo "1";
    }
    
    echo " iš ";
    echo $clients_total_pages["puslapiu_skaicius"];
    echo "</p>";

    echo "<p>";
    echo "Iš viso klientų: ";
     echo $clients_total_pages['viso_klientai'];
    echo "</p>";
}
else {
    echo "Nepavyko suskaičiuoti klientų";
}
?>

</div>


</div>
 <?php } else {
 echo 'Neturite prieigos';
}
?>


</body>


</html>

