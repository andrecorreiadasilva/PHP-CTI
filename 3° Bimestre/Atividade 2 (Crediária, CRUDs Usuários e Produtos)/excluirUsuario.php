<?php
    include ("util.php");

    $conn = conecta();
    $id = $_GET['id'];

    $varSQL = "DELETE FROM usuario 
               WHERE id_usuario = :id";
    $delete = $conn->prepare($varSQL);
    $delete->bindParam(':id', $id);

    if ($delete->execute()) {
        $imagemPath = 'imagens/u'.$id.'.jpg';

        if (file_exists($imagemPath)) {
            unlink($imagemPath);
        }
        echo "Usuário excluído com sucesso";
    } else {
        echo "Erro ao excluir usuário";
    }
    echo "<br><br><a href='usuario.php'>Voltar</a>";
?>