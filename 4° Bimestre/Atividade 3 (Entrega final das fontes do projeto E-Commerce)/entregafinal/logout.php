<?php
    session_start();
    session_destroy();
    $_SESSION['sessaoConectado'] = false;
    $_SESSION['sessaoLogin'] = "";
    $_SESSION['admin'] = false;
    header('Location: ../Home.php');
?>