<!-- 1. Sukurti dokumentą duomenubazesupildymas.php. Šis dokumentas turi sukurti 200 įrašų Klientai lentelėje. +
2. Papildyti dokumentą klientupildymoforma.php.
*Po kliento pridėjimo, turi parodyti informaciją apie klientą. +
*Tikrinti,ar teises_id laukelyje yra įvestas skaičius.+
3. Sukurti dokumentą, klientai.php. Jame turi būti atvaizduojami visi klientai esantys duomenų bazėje.
4. Paspaudus ant kliento, turi būti įmanoma redaguoti jo duomenis ir išsaugoti.
5. Kiekvieną klientą turi būti galimybė ištrinti iš duomenų bazės. -->
<?php 
require_once('connection.php');

?>

<?php


 
class Klientai {
    public $vardas;
    public $pavarde;
    public $teises_id;
   
    function __construct($a, $b, $c)
    {
        $this->vardas = $a;  
        $this->pavarde = $b;  
        $this->teises_id = $c; 
    }
}
$klientai = array();

        for($i=0; $i<200; $i++) {
            $randomid = (rand(1,5));
            // array_push($klientai, new Klientai ('vardas'.($i+1), 'Pavarde'.($i+1), 'teises_id='.rand(1,3)));
            $sql = "INSERT INTO klientai(vardas, pavarde, teises_id) VALUES ('vardas$i', 'pavarde$i', $randomid)";
                      
            if(mysqli_query($prisijungimas, $sql)) {
                echo 'Irasai yra prideti';
                echo '<br>';
                // echo 'Kliento vardas'.$_GET['vardas'],.'Kliento pavarde'.$_GET['pavarde'],.'teises_id'.$_GET['teises_id'];
              } else {
                            echo 'Kazkas ivyko negerai';
          }     
            
            
        }  
       

       
      
        

        // mysqli_close($prisijungimas);
    
    
    
       
 

// $klientaiObjektas = new Klientai();

?>