<?php require('./config/conexion.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
    <?php
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $statement = $db->prepare("SELECT * FROM personal WHERE Nombre = :username AND Password = :password");
                $statement->execute(array(':username' => $username, ':password' => $password));

                //OBtener el resultado de la consulta (el usuario)
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    session_start();
                    $_SESSION['username'] = $user['Nombre'];
                    header("Location: ./admin/admin_dashboard.php");
                    exit();
                } else {
                    $error = "Usuario o contraseña incorrectos.";
                }
            } catch (PDOException $e) {
                echo "Error de consulta: " . $e->getMessage();
            }
        }
    ?>
    <form action="index.php" method="post">
        <?php if ($error != "") { ?>
            <div style="color: red;"><?php echo $error; ?></div>
        <?php } ?>
        <label for="username">Usuario: </label>
        <input type="text" name="username" id="username"><br><br>
        <label for="password">Contraseña: </label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>