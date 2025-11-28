<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type = "text/css" href="/farmacia/css/style.css">
   <link rel="stylesheet" type="text/css" href="/farmacia/css/css/all.min.css">
</head> 
 <?php
    session_start();
    if(!empty($_SESSION['us_tipo'])){
        header('location: controlador/LoginController.php');
    }
    else{
    session_destroy();

    }
   
    ?>
<body>
    <img class = "wave" src="img/wave.png" alt="">
    <img class = "wave-right" src="img/wave-right.png" alt="">
    <div class = "contenedor">
        <div class = "img">
            <img src="img/undraw_medicine_hqqg.svg" alt="">
        </div>
        <div class = "contenido-login">
            <form action="controlador/LoginController.php" method="post">
                <img src="img/logo_mia_transparente.png" alt="">
                <h2>Farmacia Mia</h2>
                <div class="input-div dni">
                    <div class="i">
                        <i class = "fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Codigo</h5>
                        <input type="text" name="user" class="input">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa.lock"></i>
                    </div>
                    <div class="div">
                        <h5>Contraseña</h5>
                        <input type="password" name="pass" class="input">
                    </div>
                </div>
                <a href="">by CP, MR, MP</a>
                <input type="submit" class="btn" value="iniciar sesion">
            </form>
        </div>
    </div>
</body>
<script src="js/login.js" > </script>
</html>
<?php
    

?>