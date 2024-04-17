<?php
    
    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        require_once('../config/logout.php');
        logout();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Dashboard</title>
</head>
<body>
    <aside>
        <div id="titlelogo">
            <img src="../assets/img/logoSJO.png" alt="Logo SJO">
            <p>Sant Josep Obrer</p>
        </div>
        <ul>
            <li>
                <a href="#">
                    <img src="../assets/img/icon-home.png" alt="Home icon">
                    <p>Inicio</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="../assets/img/Vector.png" alt="Students icon">
                    <p>Alumnos</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="../assets/img/library.png" alt="Library icon">
                    <p>Sesiones</p>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="../assets/img/layout-grid.png" alt="Layout icon">
                    <p>Materias</p>
                </a>
            </li>
        </ul>        
    </aside>
    <main>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit, molestias? Sed repellendus blanditiis, illum, eligendi commodi saepe modi obcaecati porro quae quasi unde ad totam dolorum! Corporis aspernatur quia deserunt?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, ad aperiam dolore eum ipsum explicabo culpa natus vero asperiores repudiandae alias error voluptatem! Dicta, quidem nemo ab corporis harum porro?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta quisquam beatae iure veritatis quia repudiandae dolores suscipit nisi explicabo, dicta corporis voluptatem, aperiam laborum. Maxime fugit sint nobis magnam repellat.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi impedit unde at sit reiciendis facilis voluptatibus totam qui distinctio doloribus facere natus porro, pariatur maiores? At, magni ut? Et, illo!

        </p>
    </main>
</body>
</html>