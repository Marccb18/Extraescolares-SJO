    <?php
        require('./config/conexion.php');
        require('./config/users_control.php');
        
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio Sesión</title>
        <link rel="stylesheet" href="./assets/css/index.css">
        <link rel="icon" href="./assets/img/logoSJO-fav.svg">
    </head>
    <body>
        <form action="index.php" method="post">
            <?php if ($error != "") { ?>
                <div style="color: red;"><?php echo $error; ?></div>
            <?php } ?>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email"><br><br>
            <label for="password">Contraseña: </label>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </body>
    <script src="../assets/js/index.js"></script>
    </html>