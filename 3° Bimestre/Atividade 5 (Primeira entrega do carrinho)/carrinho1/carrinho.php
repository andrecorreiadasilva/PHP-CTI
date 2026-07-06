<?php
    include('cabecalho.php'); 

    if (isset($_SESSION['sessaoConectado'])) {
        $sessaoConectado = $_SESSION['sessaoConectado'];
        $login = $_SESSION['sessaoLogin'];
    } else {
        $sessaoConectado = false;
    }

    $idSessao = session_id();
    $idTransacao = uniqid();
    $status = 'PENDENTE'; 
    $id_compra = null;
    $conn = conecta();

    $varSQL = "SELECT id_compra, status, id_transacao FROM COMPRA WHERE sessao = :sessao";
    $select = $conn->prepare($varSQL);
    $select->bindParam(':sessao', $idSessao);
    $select->execute();
    $compra = $select->fetch();

    if (!$compra) {
        $varSQL = "INSERT INTO COMPRA (sessao, status, data, id_transacao, fk_id_usuario) VALUES (:sessao, :status, NOW(), :transacao, (SELECT id_usuario FROM usuario WHERE email = :email))";
        $insert = $conn->prepare($varSQL);
        $insert->bindParam(':sessao', $idSessao);
        $insert->bindParam(':transacao', $idTransacao);
        $insert->bindParam(':status', $status);
        $insert->bindParam(':email', $login);
        $insert->execute();
        $id_compra = $conn->lastInsertId();
        
    } else {
        $id_transacao = $compra['id_transacao'];
        $id_compra = $compra['id_compra'];
        $status = $compra['status'];
    }

    if ($sessaoConectado && $status === 'PENDENTE') {
        $varSQL = "UPDATE COMPRA SET fk_id_usuario = (SELECT id_usuario FROM usuario WHERE email = :email) WHERE id_compra = :id_compra";
        $update = $conn->prepare($varSQL);
        $update->bindParam(':email', $login);
        $update->bindParam(':id_compra', $id_compra);
        $update->execute();
    }

    function AtualizaGride($conn, $id_compra) {
        if (isset($_SESSION['sessaoConectado'])) {
            $sessaoConectado = $_SESSION['sessaoConectado'];
            $login = $_SESSION['sessaoLogin'];
        } else {
            $sessaoConectado = false;
        }

        $status = 'PENDENTE'; 

        $varSQL = "SELECT cp.fk_id_produto, p.nome, cp.quantidade, cp.valor_unitario, (cp.quantidade * cp.valor_unitario) AS subtotal
                FROM COMPRA_PRODUTO cp
                JOIN PRODUTO p ON cp.fk_id_produto = p.id_produto
                WHERE cp.fk_id_compra = :id_compra";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_compra', $id_compra);
        $select->execute();
        $produtos = $select->fetchAll();

        echo "<h1>Compras</h1>
        <b>ID Compra: $id_compra</b>
        <br><br>";  

        echo "<table border='1'>
                <tr>
                    <th>Item</th>
                    <th>Foto</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>$ Unit</th>
                    <th>$ Sub</th>
                    <th>Incluir</th>
                    <th>Excluir</th>
                </tr>";

        $total = 0;
        $item = 1;
        foreach ($produtos as $produto) {
            $foto = "img/p" . $produto['fk_id_produto'] . ".jpg";
            $htmlFoto = file_exists($foto) ? "<img src='$foto' width='60'>" : "<img src='img/semimg.jpg' width='60'>";
            $subtotal = $produto['subtotal'];
            $total += $produto['subtotal'];

            echo "<tr>
                    <td>$item</td>
                    <td>$htmlFoto</td>
                    <td>{$produto['nome']}</td>
                    <td>{$produto['quantidade']}</td>
                    <td>R$ " . number_format($produto['valor_unitario'], 2, ',', '.') . "</td>
                    <td>R$ " . number_format($subtotal, 2, ',', '.') . "</td>
                    <td><a href='carrinho.php?operacao=INCLUIR&id_produto={$produto['fk_id_produto']}'>Incluir</a></td>
                    <td><a href='carrinho.php?operacao=EXCLUIR&id_produto={$produto['fk_id_produto']}'>Excluir</a></td>
                </tr>";

            $item++;
        }

        echo "</table>";
        echo "<br>Status da compra: $status";
        echo "<br>Total: R$ " . number_format($total, 2, ',', '.');

        if ($sessaoConectado && $total > 0 && $status === 'PENDENTE') {
            echo "<br><a href='carrinho.php?operacao=FECHAR'>Fechar o carrinho</a>";
        }
    }

    $operacao = isset($_GET['operacao']) ? $_GET['operacao'] : null;
    $id_produto = isset($_GET['id_produto']) ? $_GET['id_produto'] : null;

    if ($operacao === 'INCLUIR') {
        $varSQL = "SELECT quantidade FROM COMPRA_PRODUTO WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_produto', $id_produto);
        $select->bindParam(':id_compra', $id_compra);
        $select->execute();
        $produto = $select->fetch();

        if (!$produto) {
            $varSQL = "INSERT INTO COMPRA_PRODUTO (fk_id_produto, fk_id_compra, quantidade, valor_unitario) VALUES (:id_produto, :id_compra, 1, (SELECT valor_unitario FROM PRODUTO WHERE id_produto = :id_produto))";
            $insert = $conn->prepare($varSQL);
            $insert->bindParam(':id_produto', $id_produto);
            $insert->bindParam(':id_compra', $id_compra);
            $insert->execute();
        } else {
            $varSQL = "UPDATE COMPRA_PRODUTO SET quantidade = quantidade + 1 WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
            $update = $conn->prepare($varSQL);
            $update->bindParam(':id_produto', $id_produto);
            $update->bindParam(':id_compra', $id_compra);
            $update->execute();
        }
        AtualizaGride($conn, $id_compra);
    } elseif ($operacao === 'EXCLUIR') {
        $varSQL = "SELECT quantidade FROM COMPRA_PRODUTO WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_produto', $id_produto);
        $select->bindParam(':id_compra', $id_compra);
        $select->execute();
        $produto = $select->fetch();

        if ($produto['quantidade'] > 1) {
            $varSQL = "UPDATE COMPRA_PRODUTO SET quantidade = quantidade - 1 WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
            $update = $conn->prepare($varSQL);
            $update->bindParam(':id_produto', $id_produto);
            $update->bindParam(':id_compra', $id_compra);
            $update->execute();
        } else {
            $varSQL = "DELETE FROM COMPRA_PRODUTO WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
            $delete = $conn->prepare($varSQL);
            $delete->bindParam(':id_produto', $id_produto);
            $delete->bindParam(':id_compra', $id_compra);
            $delete->execute();
        }
        AtualizaGride($conn, $id_compra);
    } elseif ($operacao === 'FECHAR') {
        header('Location: pagar.php');
        exit();
    } else {
        AtualizaGride($conn, $id_compra);
}
?>