<!DOCTYPE html>
<html>
    <?php
        include ("utilidades/cabecalho.php");
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/minhas_informacoes.css">
        <title>GKHaven - Alterar</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <?php
                    $conn = conecta();

                    $email = $_SESSION['sessaoLogin'];
                    $varSQL = "SELECT * FROM usuario 
                                WHERE email = :email";

                    $select = $conn -> prepare($varSQL);
                    $select->bindParam(':email', $email);
                    $select->execute();
                    $linha = $select -> fetch();

                    $nome = $linha['nome'];
                    $email = $linha['email'];
                    $telefone = $linha['telefone'];
                    $id = $linha['id_usuario'];

                    echo "<form action='' method='post' action=''>
                        <div class='espaco'>
                            <label>Nome de usuário: </label>
                            <input type='text' name='nome' value='$nome' required>
                        </div>
                        <div class='espaco'>
                            <label>Email: </label>
                            <input type='email' name='email' value='$email' required>
                        </div>
                        <div class='espaco'>
                            <label>Telefone: </label>
                            <input type='text' name='telefone' value='$telefone' required>
                        <div class='espaco'>
                            <button type='submit'>Alterar informações</button>
                        </div>
                    </form>";

                    if ($_POST) 
                    {
                        $varSQL = "UPDATE usuario SET nome = :nome, email = :email, telefone = :telefone WHERE id_usuario = :id";
                        $update = $conn -> prepare($varSQL);

                        $admin = isset($_POST['admin']) ? 1 : 0;

                        $update -> bindParam(':nome', $_POST['nome']);
                        $update -> bindParam(':email', $_POST['email']);
                        $update -> bindParam(':telefone', $_POST['telefone']);
                        $update -> bindParam(':id', $id);

                        if ($update->execute()) 
                        {
                            echo "<script>window.alert('Informações alteradas com sucesso! Favor logar novamente.');</script>";
                            logout();
                            echo "<script>window.location = 'Login.php'</script>";
                        } 
                        else 
                        {
                            echo "Houve um erro ao alterar o usuário.";
                        }
                    }
                ?>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>