<?php

include 'util.php';

echo "
<form method='POST' name='formulario' action=''>
    <label for='alt'>Altura (m):</label>
    <input type='number' name='alt' min='0.1' max='3' step='0.01'><br>
    <label for='peso'>Peso (Kg):</label>
    <input type='number' name='peso' min='0.1' max='500' step='0.1'><br>
    <button type='submit'>Enviar</button>
</form>";

if ( $_POST ) {
    $alt = $_POST['alt'];
    $peso = $_POST['peso'];
    if ($alt != null && $peso != null ) {
        $imc = round(calcIMC($alt, $peso),2);

        echo "IMC = " . $imc .
            "<br>Classificação = " . classIMC($imc);
    }
    else {
        echo "Por favor preencha ambos os campos";
    }
}

?>