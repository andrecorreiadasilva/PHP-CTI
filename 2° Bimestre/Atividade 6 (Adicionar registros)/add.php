<?php
    include ("util.php");

    if($_POST)
    {

        $varConn = conectar();

        $varSQL = "INSERT INTO alunos (nome, matricula, celular, email, turma, sexo)
        VALUES (:nome, :matricula, :celular, :email, :turma, :sexo)";

        $insert = $varConn->prepare($varSQL);
        $insert->bindParam(':nome', $_POST['nome']);
        $insert->bindParam(':matricula', $_POST['matricula']);
        $insert->bindParam(':celular', $_POST['celular']);
        $insert->bindParam(':email', $_POST['email']);
        $insert->bindParam(':turma', $_POST['turma']);
        $insert->bindParam(':sexo', $_POST['sexo']);
        $insert->execute();
    }
?>