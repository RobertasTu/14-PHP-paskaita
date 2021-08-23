
<?php require_once("includes.php"); 
require_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Registracija</title>

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
<body>

<?php 
if(isset($_POST["submit"])) { 
       
   $name =$_POST["vardas"];
   $username =$_POST["username"];
   $password =$_POST["password"];
   $rPassword = $_POST["rPassword"];
   $description = $_POST["description"];
  
   $sql = "SELECT * FROM `uzsiregistrave_vartotojai` WHERE slapyvardis='$username' ";
   $result = $prisijungimas->query($sql);
   $class= "danger";
   if($result->num_rows == 1) {
       $message = "Toks vartotojas duomenu bazėje jau yra";
   } else {
      if($password==$rPassword){
        
        $sql = "INSERT INTO `uzsiregistrave_vartotojai`(`vardas`, `slapyvardis`, `slaptazodis`, `teises_id`, `aprasymas`) 
        VALUES ('$name','$username','$password',1,'$description')";

        if(mysqli_query($prisijungimas, $sql)) {
            $class= "success";
            $message = "Vartotojas sukurtas sekmingai";
        } else {
            $message = "Kazkas ivyko negerai";
        }

      } else {
        $message = "Slaptažodžiai nesutampa";
      }
   }

  

}



?>

<div class='container'>
     
<h1>Registracija</h1>
        <form action='registracija.php' method='post'>
                        <div class='form-group'>
                    <label for='vardas'>Vardas :</label>
                    <input class="form-control" placeholder='Iveskite savo varda' required='true' type='text' id='vardas' name='vardas' value="<?php 
                    if(isset($name)) {
                        echo $name;
                    } else {
                        echo "";
                    }
                ?>" />
                </div>
                <div class="form-group">
                <label for="username">Vartotojo vardas :</label>
                <input class="form-control" type="text" placeholder='Iveskite vartotojo varda' name="username" required="true" value="<?php 
                    if(isset($username)) {
                        echo $username;
                    } else {
                        echo "";
                    }
                ?>"/>
            </div>


                <div class='form-group'>
                    <label for='password'>Slaptazodis :</label>
                    <input class="form-control" placeholder='Iveskite slaptazodi' type='text' id='password' name='password' required="true" />
                </div>
                <div class='form-group'>
                    <label for='rPassword'>Pakartokite slaptazodi :</label>
                    <input class="form-control" placeholder='Pakartokite slaptazodi' type='text' id='rPassword' name='rPassword' required="true" />
                </div>
                <div class="form-group">
                <label for="description">Aprasymas</label>
                <textarea class="form-control" type="text" name="description">
                    <?php 
                    if(isset($description)) {
                        echo $description;
                    } else {
                        echo "";
                    }
                ?>
                </textarea>
            </div>

                                <button class="btn btn-primary" type="submit" name="submit">Prisiregistruoti</button>
                      <?php if(isset($message)) { ?>
                <div class="alert alert-<?php echo $class; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php } ?>

                    <a href='login.php'>Prisijungti </a> 
                    
                
            </div>
        </div>
        </form>
    </div>




    <?php

if(isset($_COOKIE["prisijungti"]) ) 
    header("Location: klientai.php");

    ?>

    
    
    
    
    
</body>
</html>