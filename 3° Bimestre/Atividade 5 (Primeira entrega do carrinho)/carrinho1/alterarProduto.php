<?php
    include ("util.php");
    $conn = conecta();

    $id = $_GET['id'];
    $varSQL = "SELECT * FROM produto 
               WHERE excluido = false AND id_produto = :id";

    $select = $conn -> prepare($varSQL);
    $select -> bindParam(':id', $id);
    $select -> execute();
    $linha = $select -> fetch();

    $nome = $linha['nome'];
    $descricao = $linha['descricao'];
    $valor_unitario = $linha['valor_unitario'];
    $qtde_estoque = $linha['qtde_estoque'];

    echo "
    <form action='' method='post' enctype='multipart/form-data'>
        <label for='nome'> Nome: </label><br>
        <input type='text' name='nome' value='$nome'>
        <br>
        <label for='descricao'> Descrição: </label><br>
        <input type='text' name='descricao' value='$descricao'>
        <br>
        <label for='valor_unitario'> Valor unitário: </label><br>
        <input type='number' name='valor_unitario' value='$valor_unitario'>
        <br>
        <label for='qtde_estoque'> Quantidade no estoque: </label><br>
        <input type='number' name='qtde_estoque' value='$qtde_estoque'>
        <br>
        <label for='foto'>Foto:</label>
        <input type='file' name='foto' accept='image/*'>
        <br><br>
        <button type='submit'>Salvar</button>
    </form>";

    if ($_POST) 
    {
        $varSQL =" UPDATE produto
                SET nome = :nome, descricao = :descricao, 
                valor_unitario = :valor_unitario, 
                qtde_estoque = :qtde_estoque 
                WHERE id_produto = :id";

        $update = $conn -> prepare($varSQL);

        $update -> bindParam(':nome', $_POST ['nome']);
        $update -> bindParam(':descricao', $_POST ['descricao']);
        $update -> bindParam(':valor_unitario', $_POST ['valor_unitario']);
        $update -> bindParam(':qtde_estoque', $_POST ['qtde_estoque']);
        $update -> bindParam(':id', $id);

        if ($update->execute()) 
        {
            if ($_FILES['foto']['name']) 
            {
                $imagem = $_FILES['foto']['name'];
                $imagemPath = $_SERVER['DOCUMENT_ROOT'].'/imagens/p'.$id.'.jpg';
                move_uploaded_file($_FILES['foto']['tmp_name'], $imagemPath);
            }
            echo "Produto alterado com sucesso!";
        } 
        else
        {
            echo "Houve um erro ao alterar o produto.";
        }
    }
    echo "<br><a href='produtos.php'>Voltar</a>";
?>