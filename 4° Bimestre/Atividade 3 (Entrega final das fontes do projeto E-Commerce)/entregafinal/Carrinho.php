<!DOCTYPE html>
<html>
    <?php
        include ("utilidades/cabecalho.php");
    ?>
    <script src="js/script.js"></script>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/carrinho.css">
        <title>GKHaven - Carrinho</title>
    </head>
    <body>
        <header>
        </header>
        <nav>
            <?php nav(); ?>
        </nav>
        <article>
            <div class="geral">
                <?php
                    $conn = conecta();

                    $idSessao = session_id();
                    $idTransacao = '';
                    $status = 'PENDENTE'; 
                    $id_compra = null;


                    $varSQL = "SELECT id_compra, status, id_transacao FROM COMPRA WHERE sessao = :sessao";
                    $select = $conn->prepare($varSQL);
                    $select->bindParam(':sessao', $idSessao);
                    $select->execute();
                    $compra = $select->fetch();
                    if ($sessaoConectado)
                    {
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

                        if ($status == 'PENDENTE') {
                            $varSQL = "UPDATE COMPRA SET fk_id_usuario = (SELECT id_usuario FROM usuario WHERE email = :email) WHERE id_compra = :id_compra";
                            $update = $conn->prepare($varSQL);
                            $update->bindParam(':email', $login);
                            $update->bindParam(':id_compra', $id_compra);
                            $update->execute();
                        }

                    }
                    else {
                        echo "<script>
                        alert('Você precisa estar logado para acessar o carrinho.');
                        window.location.href = 'Login.php';
                        </script>";
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

                        $total = 0;

                        foreach ($produtos as $produto) {
                            $foto = "img/p/" . $produto['fk_id_produto'] . ".png";
                            $htmlFoto = file_exists($foto) ? "<img class='produto-img' src='$foto' width='60'>" : "<img src='img/semimg.jpg' width='60'>";
                            $subtotal = $produto['subtotal'];
                            $total += $produto['subtotal'];

                            echo "<tr>
                                    <div>$htmlFoto</div>
                                    <div class='linha'><span class='mobile'>Nome: </span>{$produto['nome']}</div>
                                    <div class='linha'><span class='mobile'>Quantidade: </span>{$produto['quantidade']}</div>
                                    <div class='linha'><span class='mobile'>Preço: </span>R$ " . number_format($produto['valor_unitario'], 2, ',', '.') . "</div>
                                    <div class='linha'><span class='mobile'>Total: </span>R$ " . number_format($subtotal, 2, ',', '.') . "</div>
                                    <div class='incluir'><span class='mobile' class='incluir'>Adicionar: </span><a class='texto-bt-i' href='Carrinho.php?operacao=INCLUIR&id_produto={$produto['fk_id_produto']}'>Incluir</a></div>
                                    <div class='excluir'><span class='mobile'>Remover: </span><a class='texto-bt-e' href='Carrinho.php?operacao=EXCLUIR&id_produto={$produto['fk_id_produto']}'>Excluir</a></div>
                                </tr>";
                        }
                        echo "</div>
                        <div class='total'>
                            <br><b>Status da compra:</b> $status
                            <br><b>Total:</b> R$ " . number_format($total, 2, ',', '.') .
                        "</div>";

                        if ($sessaoConectado && $total > 0 && $status === 'PENDENTE') {
                            echo "<br><a class='checkout-btn' href='Checkout.php'>Fechar o carrinho</a>";
                        }
                    }
           
                    echo"<h3 class='titulo'>Seu Carrinho | ID Compra: $id_compra</h3>
                        <div class='carrinho-grid'>
                        <div class='linha' class='carrinho-header'>Produto</div>
                        <div class='linha' class='carrinho-header'>Nome</div>
                        <div class='linha' class='carrinho-header'>Quantidade</div>
                        <div class='linha' class='carrinho-header'>Preço</div>
                        <div class='linha' class='carrinho-header'>Total</div>
                        <div class='linha' class='carrinho-header'>Adicionar</div>
                        <div class='linha' class='carrinho-header'>Remover</div>";

                        $operacao = isset($_GET['operacao']) ? $_GET['operacao'] : null;
                        $id_produto = isset($_GET['id_produto']) ? $_GET['id_produto'] : null;
    
                        if ($operacao === 'INCLUIR') {
                            $quantidadeSelecionada = isset($_GET['quantidade']) ? (int)$_GET['quantidade'] : 1;

                            $varSQL = "SELECT quantidade FROM COMPRA_PRODUTO WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id_produto', $id_produto);
                            $select->bindParam(':id_compra', $id_compra);
                            $select->execute();
                            $produto = $select->fetch();
                        
                            $quantidadeAtual = $produto ? $produto['quantidade'] : 0;
                        
                            $varSQL = "SELECT qtde_estoque FROM PRODUTO WHERE id_produto = :id_produto";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id_produto', $id_produto);
                            $select->execute();
                            $linhaEstoque = $select->fetch();
                            $qtde_estoque = $linhaEstoque['qtde_estoque'];
                        
                            if ($quantidadeAtual + $quantidadeSelecionada <= $qtde_estoque) {
                                if (!$produto) {
                                    $varSQL = "INSERT INTO COMPRA_PRODUTO (fk_id_produto, fk_id_compra, quantidade, valor_unitario) VALUES (:id_produto, :id_compra, :quantidade, (SELECT valor_unitario FROM PRODUTO WHERE id_produto = :id_produto))";
                                    $insert = $conn->prepare($varSQL);
                                    $insert->bindParam(':id_produto', $id_produto);
                                    $insert->bindParam(':id_compra', $id_compra);
                                    $insert->bindParam(':quantidade', $quantidadeSelecionada);
                                    $insert->execute();
                                } else {
                                    $varSQL = "UPDATE COMPRA_PRODUTO SET quantidade = quantidade + :quantidade WHERE fk_id_produto = :id_produto AND fk_id_compra = :id_compra";
                                    $update = $conn->prepare($varSQL);
                                    $update->bindParam(':quantidade', $quantidadeSelecionada);
                                    $update->bindParam(':id_produto', $id_produto);
                                    $update->bindParam(':id_compra', $id_compra);
                                    $update->execute();
                                }
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
                        } else {
                            AtualizaGride($conn, $id_compra);
                        }
                    ?>
            </div>
        </article>
        <footer>
        </footer>
    </body>
</html>