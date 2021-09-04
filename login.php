<?php require_once("includes.php"); ?>

<?php 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Prisijungimas</title>
    <style>
        h1 {
            text-align: center;
        }

        .container {
            position:absolute;
            top:50%;
            left:50%;
            transform: translateY(-50%) translateX(-50%);
        }
    </style>

</head>
<?php
if (isset($_POST["vardas"]) && !empty($_POST["vardas"]) && isset($_POST["password"]) && !empty($_POST["password"]) )
{
$vardas = $_POST["vardas"];
$password = $_POST["password"];

$sql = "SELECT * FROM `vartotojai` WHERE `vardas` = '$vardas' AND `slaptazodis` = '$password' ";

$rezultatas = $prisijungimas->query($sql);

if($rezultatas->num_rows == 1)  {
  
    $user_info = mysqli_fetch_array($rezultatas);
    $cookie_array = array(
        $user_info["ID"],
        $user_info["slapyvardis"],
        $user_info["vardas"],
        $user_info["teises_id"],
        $user_info['Registracija']
        
                
    );

      
   
    $cookie_array = implode("|", $cookie_array);
    setcookie("prisijungti",  $cookie_array, time() + 3600 * 24, "/");
    $teises_id = intval($user_info['teises_id']);
    $vardas = $user_info['vardas'];
    $slaptazodis = $user_info['slaptazodis'];
    $data = date("Y.m.d");
    $id = $user_info["ID"];
    $registracija = $user_info['Registracija'];

    
    

    if($teises_id == 1) {
      header('Location: adminlogin.php'); 
     
      
    }
   
    if($teises_id == 2) {
      
        header('Location: vadyblogin.php');
    }

    if($registracija == 1) {
        header("Location: 404.php");
        
    }

  


     

} else {
    
    header('login.php');
    $message = "Neteisingi prisijungimo duomenys";
} 
}







?>
<body>

<?php if(!isset($_COOKIE["prisijungti"])) { ?>

<div class='container'>
     <h1>Prisijungimas</h1>
        <form action='login.php' method='post'>
            <div class='form-group'>
                    <label for='vardas'>Vardas :</label>
                    <input class="form-control" placeholder='Iveskite savo varda' type='text' id='vardas' name='vardas' />
            </div>
            <div class='form-group'>
                    <label for='password'>Slaptazodis</label>
                    <input class="form-control" placeholder='Iveskite slaptazodi' type='text' id='password' name='password' />
            </div>
            
                     <button class='btn btn-primary' type='submit' name='submit'>Prisijungti</button>
                               
                           <a class='btn btn-primary' href='registracija.php'>Registruotis</a> <br>

                              <a class='btn btn-primary' href='forgot.php'>Priminti slaptazodi</a>
            </form>        
            
           
        
        
        <?php if(isset($message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>
    </div>
    <?php } else {
        header("Location: klientai.php");
    } ?>


</div>

 
   

    
    
    
    
    
</body>
</html>