<?php
    include("../utilidades/util.php");
    session_start();

    if ($_SESSION['admin']) {
        echo "
        <form action='' method='post' enctype='multipart/form-data'>
            <label for='nome'>Nome:</label>
            <input type='text' name='nome' required>
            <br>
            <label for='descricao'>Descrição:</label>
            <textarea name='descricao' required></textarea>
            <br>
            <label for='valor_unitario'>Valor unitário:</label>
            <input type='text' name='valor_unitario' required>
            <br>
            <label for='qtde_estoque'>Quantidade em estoque:</label>
            <input type='number' name='qtde_estoque' required>
            <br>
            <label for='foto'>Foto:</label>
            <input type='file' name='foto' accept='image/*' required>
            <br><br>
            <button type='submit'>Enviar</button>
        </form>";

        if($_POST)
        {
            $conn = conecta();

            $varSQL = "INSERT INTO produto (nome, descricao, valor_unitario, excluido, qtde_estoque) 
                    VALUES (:nome, :descricao, :valor_unitario, false, :qtde_estoque)";
            
            $insert = $conn -> prepare($varSQL);

            $insert->bindParam(":nome", $_POST['nome']);
            $insert->bindParam(":descricao", $_POST['descricao']);
            $insert->bindParam(":valor_unitario", $_POST['valor_unitario']);
            $insert->bindParam(":qtde_estoque", $_POST['qtde_estoque']);
            
            if ($insert->execute())
            {
                $idProduto = $conn -> lastInsertId();
                $imagem = $_FILES['foto']['name'];
                $imagemPath = '../img/p/'.$idProduto.'.png';
                move_uploaded_file($_FILES['foto']['tmp_name'], $imagemPath);

                echo "Produto cadastrado com sucesso!";
            } 
            else 
            {
                echo "Houve um erro ao cadastrar o produto.";
            }
        }
        echo "<br><a href='produtos.php'>Voltar</a>";
    }
    else {
        echo "Acesso proibido";
    }
?>