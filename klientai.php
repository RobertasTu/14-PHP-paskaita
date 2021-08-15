<!-- 3. Sukurti dokumentą, klientai.php. Jame turi būti atvaizduojami visi klientai esantys duomenų bazėje.
4. Paspaudus ant kliento, turi būti įmanoma redaguoti jo duomenis ir išsaugoti.
5. Kiekvieną klientą turi būti galimybė ištrinti iš duomenų bazės. -->

<?php 
require_once('connection.php');

$sql = "SELECT * FROM `klientai` WHERE 1"; 
$rezultatas = $prisijungimas->query($sql); 



while($klientai = mysqli_fetch_array($rezultatas)) {
    echo $klientai['ID'];
    echo' ';
    echo $klientai['vardas'];
    echo ' ';
    echo $klientai['pavarde'];
    echo ' ';
    echo $klientai['teises_id'];
    echo ' ';
    // echo '<form action="klientai.php?istrinti='.$klientai['ID'].'" method="get" >';
    // echo '<button type="submit" name="redaguoti">Redaguoti</button>';
    // echo '<button type="submit" name="istrinti">Istrinti</button>';
    // echo '</form>';

    echo "<a href='klientai.php?edit=".$klientai["ID"]."'>Redaguoti</a>";
    echo " ";
    echo "<a href='klientai.php?delete=".$klientai["ID"]."'>Istrinti</a>";
    echo "<br>";
}
   
   


//     echo '<br>';
// }

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $prisijungimas->query ("DELETE FROM `klientai` WHERE `ID` = $id;");
    header('location:klientai.php');
  }

  if(isset($_GET['edit'])) {
      $id = $_GET['edit'];
      echo '<br>';
      echo 'Redaguojame kliento duomenis '.'Kliento id='.$id;
      $sql = "SELECT * FROM `klientai` WHERE ID=$id";
      $rezultatas = $prisijungimas->query($sql);
      $klientai = mysqli_fetch_array($rezultatas);
        echo '<br>';
        echo $klientai['ID'];
        echo' ';
        echo $klientai['vardas'].'-Vardas';
        echo ' ';
        echo $klientai['pavarde'].'-Pavarde';
        echo ' ';
        echo $klientai['teises_id'].'-Suteiktos teises';
        echo ' ';
       echo "<form action='klientai.php' method='get'>";
    echo "<input type='text' name='naujas_vardas' placeholder='Naujas vardas' id='naujas_vardas' />";
    echo "<input type='text' placeholder='Nauja pavarde' name='nauja_pavarde' id='nauja_pavarde' />";
    echo "<select name='teises_id_naujas' id='teises_id_naujas'>";
        echo "<option value='1'>1</option>";
       echo "<option value='2'>2</option>";
       echo "<option value='3'>3</option>";
       echo "<option value='4'>4</option>";
       echo "<option value='5'>5</option>";
   echo "</select>";
    echo "<button type='submit' name='pakeisti'>Pakeisti kliento informacija</button>";
// echo "</form>";

if(isset($_GET['pakeisti'])) {
    if(isset($_GET['naujas_vardas']) && !empty($_GET['naujas_vardas']) && isset($_GET['nauja_pavarde']) && !empty($_GET['nauja_pavarde']) && isset($_GET['teises_id_naujas']) && !empty($_GET['teises_id_naujas'])) {
        $vardas = $_GET['naujas_vardas'];
        $pavarde = $_GET['nauja_pavarde'];
        $teises_id = $_GET['teises_id_naujas'];
        
        $sql = "UPDATE `klientai` SET `vardas`='$vardas',`pavarde`='$pavarde',`teises_id`=$teises_id WHERE `ID`=$id";

        if(mysqli_query($prisijungimas, $sql)) {
              echo 'Kliento duomenys pakeisti i:';
              echo '<br>';
              echo 'Vardas:'.$vardas.'<br>'; 
              echo 'Pavarde:'.$pavarde.'<br>';
              echo 'Teises_id:'.$teises_id.'<br>';
              echo '<br>';
            } else {
                echo 'Kazkas ivyko negerai';
                }

  
            }
        }
        echo "</form>";
  }

    // echo '<form>';
    // echo 'Redaguojame irasa'.'Klientas'$id;
    // echo '</form>';
    // $sql = "SELECT * FROM `klientai` WHERE ID=$_GET['klientoid']";
    // echo "<form action='klientai.php' method='get'>"
    // echo "<input type='text' name='vardas' placeholder='$klientai["vardas"]'/>"
    // echo "<input type='text' placeholder='$klientai["pavarde"]' name='pavarde'/>"
    // echo "<select name='teises_id' id='teises_id'>
    //     <option value='1'>1</option>
    //     <option value='2'>2</option>
    //     <option value='3'>3</option>
    //     <option value='4'>4</option>
    //     <option value='5'>5</option>
    // </select>"


    // echo "<button type='submit' name='prideti'>Pakeisti kliento duomenis</button>"


    // echo "</form>"

?>

