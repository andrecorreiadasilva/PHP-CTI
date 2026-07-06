<?php
    include("../utilidades/util.php");
    $conn = conecta();
    session_start();

    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        $id = $_GET['id'];

        $varSQL = "UPDATE produto 
                SET excluido = true, data_exclusao = NOW() 
                WHERE id_produto = :id";
        $update = $conn -> prepare($varSQL);
        $update -> bindParam(':id', $id);

        if ($update->execute()) 
        {
            echo "Produto excluído com sucesso!";
        } 
        else 
        {
            echo "Houve um erro ao excluir o produto.";
        }
        echo "<br><a href='produtos.php'>Voltar</a>";
    }
    else {
        echo "Acesso proibido";
    }
?>