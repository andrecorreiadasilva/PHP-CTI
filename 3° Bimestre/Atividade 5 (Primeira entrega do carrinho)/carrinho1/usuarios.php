<?php
    include("util.php");
    $conn = conecta();

    $varSQL = "SELECT * FROM usuario";
    $select = $conn->prepare($varSQL);
    $select -> execute();

    echo "
    <table border='1'>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Admin</th>
            <th>Foto</th>
            <th></th>
        </tr>";

    while ($linha = $select -> fetch()) 
    {
        echo "<tr>";
            echo "<td>".$linha['nome']."</td>";

            echo "<td>".$linha['email']."</td>";

            echo "<td>".$linha['telefone']."</td>";

            echo "<td>".($linha['admin'] ? 'Sim' : 'Não')."</td>";

            $foto = "img/u".$linha['id_usuario'].".jpg";

            echo "<td>".$htmlFoto = (file_exists($foto) ? "<img src='$foto'
                       width=60>" : "<img src='img/semimg.jpg' width=60>")."<br><b></td>";

            echo "<td><a href='alterarUsuario.php?id=".$linha['id_usuario']."'>Alterar</a> <a href='excluirUsuario.php?id=".$linha['id_usuario']."'>Excluir</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<a href='adicionarUsuario.php'>Adicionar Usuário</a>";
?>