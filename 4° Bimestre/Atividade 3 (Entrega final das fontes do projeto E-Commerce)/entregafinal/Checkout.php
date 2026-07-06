<!DOCTYPE html>
<html>
    <?php
        include("utilidades/cabecalho.php");
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/checkout.css">
        <link rel="stylesheet" href="style/style.css">
        <title>GKHaven - Checkout</title>
    </head>
    <body>
        <header>
        </header>
        <nav>
            <?php nav(); ?>
        </nav>
        <article>
            <?php
                if (isset($_SESSION['sessaoConectado'])) {
                    $sessaoConectado = $_SESSION['sessaoConectado'];
                    $login = $_SESSION['sessaoLogin'];
                } else {
                    $sessaoConectado = false;
                }

                $conn = conecta();
                $idSessao = session_id();
                $varSQL = "SELECT c.id_compra, SUM(cp.quantidade * cp.valor_unitario) AS total 
                        FROM COMPRA c
                        JOIN COMPRA_PRODUTO cp ON c.id_compra = cp.fk_id_compra
                        WHERE c.sessao = :sessao AND c.status = 'PENDENTE'
                        GROUP BY c.id_compra";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':sessao', $idSessao);
                $select->execute();
                $compra = $select->fetch();

                if ($compra) {
                    $id_compra = $compra['id_compra'];
                    $total = $compra['total'];
                    $id_transacao = '';
                } else {
                    echo "<script>window.alert('Compra não encontrada!');
                                window.location = 'Home.php';
                    </script>";
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id_transacao = '';
                    $acrescDesc = $_POST['acresc_desc'];

                    $totalFinal = $total + $acrescDesc;

                    $varSQL = "UPDATE COMPRA 
                            SET status = 'FINALIZADO', total = :total, id_transacao = :id_transacao, acrescimo_total = :acresc 
                            WHERE id_compra = :id_compra";
                    $update = $conn->prepare($varSQL);
                    $update->bindParam(':total', $totalFinal);
                    $update->bindParam(':id_transacao', $id_transacao);
                    $update->bindParam(':id_compra', $id_compra);
                    $update->bindParam(':acresc', $acrescDesc);

                    if ($update->execute()) {
                        $varSQL = "UPDATE PRODUTO SET qtde_estoque = qtde_estoque - :quantidade WHERE id_produto = :id_produto";
             
                        $varSQLProdutos = "SELECT fk_id_produto, quantidade 
                                            FROM COMPRA_PRODUTO 
                                            WHERE fk_id_compra = :id_compra";

                        $select = $conn -> prepare($varSQLProdutos);
                        $select -> bindParam(':id_compra', $id_compra);
                        $select -> execute();
                        $produtosComprados = $select -> fetchAll();
            
                        foreach ($produtosComprados as $produto) {
                            $idProduto = $produto['fk_id_produto'];
                            $quantidadeComprada = $produto['quantidade'];
            
                            $update = $conn -> prepare($varSQL);
                            $update -> bindParam(':quantidade', $quantidadeComprada);
                            $update -> bindParam(':id_produto', $idProduto);
                            $update -> execute();
                        }

                        session_regenerate_id();
                        setcookie('idSessao', session_id(), time()+86400);
                    }
                    else {
                        echo "<script>window.alert('Erro na finalização da compra. Tente novamente mais tarde');
                            window.location = 'Carrinho.php';
                        </script>";
                    }
                    
                    echo "<script>window.alert('Compra finalizada com sucesso! Total final: R$ " . number_format($totalFinal, 2, ',', '.') . "');
                        window.location = 'Home.php';
                    </script>";
                }

                $varSQL = "SELECT cp.fk_id_produto, p.nome, cp.quantidade, cp.valor_unitario, (cp.quantidade * cp.valor_unitario) AS subtotal
                            FROM COMPRA_PRODUTO cp
                            JOIN PRODUTO p ON cp.fk_id_produto = p.id_produto
                            WHERE cp.fk_id_compra = :id_compra";
                $select = $conn->prepare($varSQL);
                $select->bindParam(':id_compra', $id_compra);
                $select->execute();
                $produtos = $select->fetchAll();

                $total = 0;

                echo "
                <div class='geral'>
                    
                    <h3>Checkout</h3>
                    <div class='checkout-grid'>
                        <div class='checkout-header'>Nome</div>
                        <div class='checkout-header'>Quantidade</div>
                        <div class='checkout-header'>Preço Unitário</div>
                        <div class='checkout-header'>Subtotal</div>";

                foreach ($produtos as $produto) {
                    $subtotal = $produto['subtotal'];
                    $total += $produto['subtotal'];

                    echo "
                        <div><span class='mobile'>Nome: </span>{$produto['nome']}</div>
                        <div><span class='mobile'>Quantidade: </span>{$produto['quantidade']}</div>
                        <div><span class='mobile'>Preço: </span>R$ " . number_format($produto['valor_unitario'], 2, ',', '.') . "</div>
                        <div><span class='mobile'>Total: </span>R$ " . number_format($subtotal, 2, ',', '.') . "</div>
                        ";
                }
                echo "
                    </div>
                ";
            ?>

                <h3>Pagamento da Compra</h3><br>
                <div class="checkout-grid">
                    <form action="Checkout.php" method="post">
                        <b>
                            ID Compra: <?php echo $id_compra; ?> <br>
                            Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
                        </b><br><br>
                        <label for="acresc_desc">Acréscimo/Desconto (+/-):</label><br>
                        <input type="number" id="acresc_desc" max="100.00" min="-100.00" name="acresc_desc" step="0.01" value="0.00">
                        <br><br>
                        <button type="submit" class="checkout-btn">Finalizar Compra</button>
                    </form>
                </div>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>