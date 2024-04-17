<?php
    session_start();

    if (isset($_SESSION['email'])) {
        header('Location: ../admin/admin_dashboard.php');
        exit();
    }
    $error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['email'];
        $password = $_POST['password'];

        try {
            $statement = $db->prepare("SELECT * FROM personal WHERE Email = :email AND Password = :password");
            $statement->execute(array(':email' => $username, ':password' => $password));

            //Obtener el resultado de la consulta (el usuario)
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['email'] = $user['Email'];
                $_SESSION['username'] = $user['Nombre'];
                if ($user['ROL'] == 'ADM') {
                    $ruta = './admin/admin_dashboard.php';
                } elseif ($user['ROL'] == 'COO') {
                    $ruta = "./coordinador_dashboard.php";
                } else {
                    $ruta = "./profesor_dashboard.php";
                }
                header("Location: $ruta");
                exit();
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
        }
    }

    function logout() {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
?>