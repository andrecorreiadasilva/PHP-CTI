<?php
    include('cabecalho.php'); 

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
        $id_transacao = isset($compra['id_transacao']) ? $compra['id_transacao'] : null;
    } else {
        echo "Compra não encontrada!";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voucher = $_POST['voucher'];
        $voucherConfirmacao = $_POST['voucher_confirmacao'];
        $acrescDesc = $_POST['acresc_desc'];

        if (!($voucher === $voucherConfirmacao)) {
            echo "Os vouchers informados não coincidem. ";
        } elseif (strlen($voucher) > 11 || strlen($voucherConfirmacao) > 11) {
            echo "O voucher deve conter no máximo 11 dígitos.";
        } else {
            $totalFinal = $total + $acrescDesc;

            $varSQL = "UPDATE COMPRA 
                       SET status = 'FINALIZADO', total = :totalFinal, id_transacao = :voucher, acrescimo_total = :acresc 
                       WHERE id_compra = :id_compra";
            $update = $conn->prepare($varSQL);
            $update->bindParam(':totalFinal', $totalFinal);
            $update->bindParam(':voucher', $voucher);
            $update->bindParam(':id_compra', $id_compra);
            $update->bindParam(':acresc', $acrescDesc);
            if ($update->execute()) {
                session_regenerate_id();
                setcookie('idSessao', session_id(), time()+86400);
            }
            else {
                echo "Erro na finalização da compra. Tente novamente mais tarde";
                exit();
            }
            echo "Compra finalizada com sucesso! Total final: R$ " . number_format($totalFinal, 2, ',', '.');
            exit();
        }
    }
?>

<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Pagar Compra</title>
    </head>
    <body>
        <h1>Pagamento da Compra</h1>
        <form action="pagar.php" method="post">
            <b>
            ID Compra: <?php echo $id_compra; ?>
            <br>
            Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
            </b>
            <br><br>
            <label for="acresc_desc">Acréscimo/Desconto (+/-):</label><br>
            <input type="number" id="acresc_desc" name="acresc_desc" step="0.01" value="0.00">
            <br>
            <label for="voucher">Informe o Voucher:</label><br>
            <input type="number" id="voucher" name="voucher" required>
            <br>
            <label for="voucher_confirmacao">Redigite o Voucher:</label><br>
            <input type="number" id="voucher_confirmacao" name="voucher_confirmacao" required>
            <br><br>
            <button type="submit">Finalizar Compra</button>
        </form>
    </body>
</html>
