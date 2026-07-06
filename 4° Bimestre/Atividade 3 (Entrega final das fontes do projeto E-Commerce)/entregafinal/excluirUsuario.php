<?php
    include("../utilidades/util.php");
    $conn = conecta();
    session_start();

    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        $id = $_GET['id'];

        $varSQL = "DELETE FROM usuario 
                WHERE id_usuario = :id";
        $delete = $conn->prepare($varSQL);
        $delete->bindParam(':id', $id);

        if ($delete->execute()) 
        {
            $imagemPath = '../img/u/'.$idUsuario.'.png';

            if (file_exists($imagemPath)) 
            {
                unlink($imagemPath);
            }
            echo "Usuário excluído com sucesso!";
        } 
        else 
        {
            echo "Houve um erro ao excluir o usuário.";
        }
        echo "<br><a href='usuarios.php'>Voltar</a>";
    }
    else {
        echo "Acesso proibido";
    }
?>