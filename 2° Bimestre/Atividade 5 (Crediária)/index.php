<?php
    echo "
    <form method='POST' name='formulario' action=''>
        <label for='sexo'>Sexo:</label>
        <select name='sexo'>
            <option value='F'>Feminino</option>
            <option value='M'>Masculino</option>
        </select>
        <label for='turma'>Turma:</label>
        <select name='turma'>
            <option value='2INIA'>2INIA</option>
            <option value='2INIB'>2INIB</option>
            <option value='2INF'>2INF</option>
        </select>
        <button type='submit'>Enviar</button>
    </form>";
    
    if ($_POST) 
    {
        $string_conexao = "";
        $conn = new PDO($string_conexao);

        if (!$conn)
        {
            echo "Não conectado";
            exit;
        }

        $varSQL = "SELECT * FROM alunos
            WHERE (sexo = :sexo) and (turma = :turma)";

        $filtroSexo = $_POST['sexo'];
        $filtroTurma = $_POST['turma'];
        $select = $conn->prepare($varSQL);
        $select->bindParam (":sexo", $filtroSexo);
        $select->bindParam (":turma", $filtroTurma);
        $select->execute();

        echo "<table border=1>
                <tr>
                    <td> <strong> ID </strong> </td>
                    <td> <strong> Nome </strong> </td>
                    <td> <strong> Sexo </strong> </td>
                    <td> <strong> Turma </strong> </td>
                    <td> <strong> Matrícula </strong> </td>
                    <td> <strong> Celular </strong> </td>
                    <td> <strong> E-mail </strong> </td>
                </tr>
        ";
        while ( $linha = $select->fetch() ) 
        {
            echo "<tr>";
                echo "<td>";
                    echo $linha["id"];
                echo "</td>";
            
                echo "<td>";
                    echo $linha["nome"];
                echo "</td>";

                echo "<td>";
                    echo $linha["sexo"];
                echo "</td>";

                echo "<td>";
                    echo $linha["turma"];
                echo "</td>";

                echo "<td>";
                    echo $linha["matricula"];
                echo "</td>";

                echo "<td>";
                    echo $linha["celular"];
                echo "</td>";

                echo "<td>";
                    echo $linha["email"];
                echo "</td>";
            echo "</tr>";       
        }
        echo "</table>" ;
    }
?>