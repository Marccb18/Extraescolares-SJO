<?php
    function logout(){
        session_destroy();
        header('Location: ../index.php');
        exit();
    }
?>