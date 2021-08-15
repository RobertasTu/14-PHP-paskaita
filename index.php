<?php 

//1. Turime prisijungti prie duomenu bazes
//2. Atlikti ta tikras uzklausas(select, update, delete, insert)
//3. Uzdaryti prisijungima

// 1.Prisijungimas

require_once('connection.php');
//connection.php faile , index.php faile dabar yra pasiekiami

$sql = "SELECT * FROM `klientai` WHERE 1"; //tekstas
$rezultatas = $prisijungimas->query($sql); //vykdo uzklausa(kaip mygtukas vykdyti)

//$result = mysqli_query($prisijungimas,$sql); - gali buti toks kodas

//Grazina ne viena rezultata, reikia ciklo

while($klientai = mysqli_fetch_array($rezultatas)) {
    echo $klientai['ID'];
    echo' ';
    echo $klientai['vardas'];
    echo ' ';
    echo $klientai['pavarde'];
    echo ' ';
    echo $klientai['teises_id'];
    echo '<br>';
}

// is uzklausos paimk rezultatus ir juos sudek i masyva

mysqli_close($prisijungimas); // uzdaromas rysys su duomenu baze

var_dump($klientai);


?>