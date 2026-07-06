<?php
    include ("util.php");
    $conn = conectar();

    if(!$conn)
        echo "Conexão falhada";
    else
    {
        $varSQL = "SELECT * FROM alunos";
        $select = $conn->query($varSQL);
    }
    echo "<table border=1>
            <tr>
                <td>ID</td>
                <td>Nome</td>
                <td>Matrícula</td>
                <td>Celular</td>
                <td>E-mail</td>
                <td>Sexo</td>
                <td>Turma</td>
                <td></td>
                <td></td>
            </tr>";
    while ($linha = $select->fetch())
    {
        echo "<tr>";
            echo "<td>".$linha['id']."</td>";
            echo "<td>".$linha['nome']."</td>";
            echo "<td>".$linha['matricula']."</td>";
            echo "<td>".$linha['celular']."</td>";
            echo "<td>".$linha['email']."</td>";
            echo "<td>".$linha['sexo']."</td>";
            echo "<td>".$linha['turma']."</td>";
            echo "<td><a href='alterarAlunos.php?id=".$linha['id']."'>Alterar</a></td>";
            echo "<td><a href='excluirAlunos.php?id=".$linha['id']."'>Excluir</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<td><a href='adicionarAlunos.php'>Adicionar</a></td>";
?>