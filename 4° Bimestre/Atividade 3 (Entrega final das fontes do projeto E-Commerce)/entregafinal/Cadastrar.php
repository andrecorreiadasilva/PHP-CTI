<!DOCTYPE html>
<html>
    <?php
        include ("utilidades/util.php");
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/cadastrar.css">
        <title>GKHaven - Cadastrar</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <h3>Cadastro</h3>
                <?php
                    echo "
                    <form action='' method='post' action=''>
                        <div class='espaco'>
                            <label>Nome de usuário:</label>
                            <input type='text' name='nome' required>
                        </div>
                        <div class='espaco'>
                            <label>Email:</label>
                            <input type='email' name='email' required>
                        </div>
                        <div class='espaco'>
                            <label>Senha:</label>
                            <input type='password' name='senha' required>
                        </div>
                        <div class='espaco'>
                            <label>Telefone:</label>
                            <input type='text' name='telefone'>
                        </div>
                        <div class='espaco' id='logar'>
                            <button type='submit' class='logar'>Enviar</button>
                            <a href='Login.php'>Já tem uma conta? Logue aqui!</a>
                        </div>
                    </form>";

                    if($_POST)
                    {
                        $conn = conecta();

                        $varSQL = "INSERT INTO usuario (nome, email, senha, telefone, admin)
                                VALUES (:nome, :email, :senha, :telefone, false)";

                        $insert = $conn->prepare($varSQL);            
                        $insert->bindParam(':nome', $_POST['nome']);
                        $insert->bindParam(':email', $_POST['email']);
                        $insert->bindParam(':senha', $_POST['senha']);
                        $insert->bindParam(':telefone', $_POST['telefone']);

                        if ($insert->execute())
                            echo "<script>window.alert('Usuário cadastrado com sucesso!');</script>";
                        else
                            echo "<script>window.alert('Houve um erro ao cadastrar o usuário.');</script>";

                    }
                ?>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>