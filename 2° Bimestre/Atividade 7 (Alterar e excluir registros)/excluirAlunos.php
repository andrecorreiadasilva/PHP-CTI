<?php   
    $id = $_GET['id'];
    include ("util.php");
    $conn = conectar();        
    $varSQL = "DELETE FROM alunos WHERE id = :id";
    $select = $conn->prepare($varSQL);
    $select->bindParam(':id', $id);
    $select->execute();
    echo "<a href='alunos.php'>Retornar</a>";
?>