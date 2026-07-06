<?php
    echo "
        <form method='POST' name='formulario' action=''>
            <label for='idusuario'>Id usuário:</label>
            <input type='text' name='idusuario'><br>
            <label for='idplaylist'>Id da playlist:</label>
            <input type='text' name='idplaylist'><br>
            <label for='v'>Id do vídeo:</label>
            <input type='text' name='v' value='fJ9rUzIMcZQ'><br>
            <button type='submit'>Enviar dados</button>
        </form>";
    
    if ( $_POST ) {
        $idusuario = $_POST['idusuario'];
        $v = $_POST['v'];
        $idplaylist = $_POST['idplaylist'];
        echo "O usuário identificado como $idusuario
              adicionou o vídeo de ID $v à playlist $idplaylist";
    }
?>