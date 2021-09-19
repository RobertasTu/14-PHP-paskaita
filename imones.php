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

<?php if ( $cookie_teises_id==1 || $cookie_teises_id==2 || $cookie_teises_id==3 || $cookie_teises_id==4)  { ?>
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

  <div class="row">
  <div class="col-lg-12 col-md-12">
        <h3>Filtravimas ir rikiavimas</h3>
  
  <form action="imones.php" method="get">

<div class="form-group">
<select class="form-control" name="rikiuoti_pagal">
      <?php
            $sql = "SELECT * FROM `imones_rikiavimas`";

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
                         $sql = "SELECT * FROM imones_tipas";
                         $rezultatas = $prisijungimas->query($sql);

                         while($companyType = mysqli_fetch_array($rezultatas)) {
                            if(isset($_GET["filtravimas_id"]) && $_GET["filtravimas_id"] == $companyType["tipas_ID"] ) {
                                echo "<option value='".$companyType["tipas_ID"]."' selected='true'>";
                            } else  {
                                echo "<option value='".$companyType["tipas_ID"]."'>";
                            }
                                echo $companyType["aprasymas"];
                            echo "</option>";
                        }
                        ?>
                        </select> 
    <button class="btn btn-primary" name="filtruoti" type="submit">Vykdyti</button>
</div>

</form>
<?php   if(isset($_GET["filtravimas_id"]) && !empty($_GET["filtravimas_id"]) && $_GET["filtravimas_id"] != "default") { ?>
            <a class="btn btn-primary" href="imones.php">Išvalyti filtrą</a>
        <?php } ?>
<?php if($cookie_teises_id!=3) { ?>
<a href='imonespildymoforma.php' class='btn btn-primary'>Pridėti naują įmonę</a>
 <?php } ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Įmonės pavadinimas</th>
          <th scope="col">Įmonės aprašymas</th>
          <th scope="col">Įmonės tipas</th>
          <?php  if($cookie_teises_id!=3) { ?>
          <th scope="col">Veiksmai</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
  <?php

$company_count = 30;
$pagination_url = ""; 

if(isset($_GET["page-limit"])) {
  $page_limit = $_GET["page-limit"] * $company_count - $company_count;    
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
  $filtravimas = 'imones.tipas_id ='.$_GET['filtravimas_id'];
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
$sql = "SELECT imones.ID, imones.pavadinimas AS imones_pavadinimas, imones.aprasymas AS imones_aprasymas, imones_tipas.aprasymas AS tipo_aprasymas
FROM imones
LEFT JOIN imones_tipas
ON imones.tipas_ID = imones_tipas.ID  
WHERE $filtravimas
ORDER BY $rikiuoti_pagal $rikiavimas
LIMIT $page_limit , $company_count
";

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $search = $_GET["search"];

  $sql = "SELECT imones.ID, imones.pavadinimas AS imones_pavadinimas, imones.tipas_ID, imones.aprasymas, imones_tipas.aprasymas AS tipo_aprasymas
  FROM imones
  LEFT JOIN imones_tipas ON imones.tipas_ID = imones_tipas.ID

  WHERE imones.pavadinimas LIKE '%".$search."%' 
  ORDER BY $rikiuoti_pagal $rikiavimas
  LIMIT $page_limit , $company_count
  ";
}

$rezultatas = $prisijungimas->query($sql);


  while($imones = mysqli_fetch_array($rezultatas)) {
    echo '<tr>';
      echo '<td>'. $imones['ID'].'</td>';
      echo '<td>'. $imones['imones_pavadinimas'].'</td>';
      echo '<td>'. $imones['imones_aprasymas'].'</td>';
      echo '<td>'. $imones['tipo_aprasymas'].'</td>'; 

      if($cookie_teises_id!=3) {    
      echo '<td>';
        echo "<a href='imonesredagavimas.php?ID=".$imones["ID"]."'>Redaguoti</a><br>"; 
        echo "<a href='imones.php?ID=".$imones["ID"]."'>Istrinti</a>";
      echo '</td>';
      }
    echo '</tr>';
}
   



?>
 
  </tbody>
</table>
<?php

if(isset($_GET["search"]) && !empty($_GET["search"])) {
  $page_filtering = "imones.pavadinimas LIKE '%".$search."%' OR imones.aprasymas 
  LIKE '%".$search."%' AND $filtravimas";
} else {
  $page_filtering = $filtravimas;
}


$sql = "SELECT CEILING(COUNT(ID)/$company_count) AS puslapiu_skaicius, COUNT(ID) AS total_companies 
FROM imones
WHERE $page_filtering
";
$rezultatas = $prisijungimas->query($sql);  
//Kiek irasu grazina sita uzklausa?
//1 irasas
if($rezultatas->num_rows == 1) { 
    $company_total_pages = mysqli_fetch_array($rezultatas);
    // var_dump($clients_total_pages);
    
    for($i = 1; $i <= intval($company_total_pages['puslapiu_skaicius']); $i++) {

      if(!isset($_GET["page-limit"]) && $i==1) {
        //Ar tikrai mes $i turim perduot?
        echo "<a class='btn btn-primary' href='klientai.php?page-limit=$i$pagination_url'>";
      } else if((isset($_GET["page-limit"]) && $_GET["page-limit"] == $i) )
      {
        echo "<a class='btn btn-primary active' href='imones.php?page-limit=$i$pagination_url'>";
      } else {
        echo "<a class='btn btn-primary' href='imones.php?page-limit=$i$pagination_url'>";
      }
            echo $i; //puslapio numeris
            echo " ";
        echo "</a>";
    }
    
    echo "<p>";
    echo "Iš viso puslapių: ";
    echo $company_total_pages['puslapiu_skaicius'];
    echo "</p>";

    echo "<p>";
    if (isset($_GET["page-limit"])) {
        echo $_GET["page-limit"];
    } else {
        echo "1";
    }
    
    echo " iš ";
    echo $company_total_pages["puslapiu_skaicius"];
    echo "</p>";

    echo "<p>";
    echo "Iš viso įmonių: ";
     echo $company_total_pages['total_companies'];
    echo "</p>";
}
else {
    echo "Nepavyko suskaičiuoti įmonių";
}
?>

</div>

</div>
<!-- <?php } else {
 echo 'Neturite prieigos';
}
?> -->
</body>