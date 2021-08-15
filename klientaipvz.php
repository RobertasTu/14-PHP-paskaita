<?php 

require_once('connection.php');

$sql = "SELECT * FROM `klientai` WHERE ID=12"; 
$rezultatas = $prisijungimas->query($sql); 



while($klientai = mysqli_fetch_array($rezultatas)) {
    echo $klientai['ID'];
    echo' ';
    echo $klientai['vardas'];
    echo ' ';
    echo $klientai['pavarde'];
    echo ' ';
    echo $klientai['teises_id'];

    echo '<a href="klientai.php?klientoid='.$klientai['ID'].'">'.$klientai['vardas'].'</a>';


    echo '<br>';
}

if(isset($_GET['klientoid'])) {
    echo '<form>';
    echo 'Redaguojame irasa'.$_GET['klientoid'];
    echo '</form>';
}


?>