<?php
    // function logout(){
    //     session_destroy();
    //     header('Location: ../index.php');
    //     exit();
    // }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_destroy();
        header('Location: ../index.php');
        exit();
    }

?>