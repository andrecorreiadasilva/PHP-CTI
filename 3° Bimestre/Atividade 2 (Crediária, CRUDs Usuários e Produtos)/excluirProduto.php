<?php
    include ("util.php");

    $conn = conecta();
    $id = $_GET['id'];

    $varSQL = "UPDATE produto 
               SET excluido = true, data_exclusao = NOW() 
               WHERE id_produto = :id";
    $update = $conn->prepare($varSQL);
    $update->bindParam(':id', $id);

    if ($update->execute()) {
        echo "Produto excluído com sucesso";
    } else {
        echo "Erro ao excluir produto";
    }

    echo "<br><br><a href='produto.php'>Voltar</a>";
?>