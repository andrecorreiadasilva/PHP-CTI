<?php

function calcIMC ($paramAlt, $paramPeso) {
    return $paramPeso / ($paramAlt * $paramAlt);
}

function classIMC ($paramIMC) {
    if ($paramIMC < 17) 
        return 'Muito abaixo do peso';
    else if ($paramIMC < 18.5) 
        return 'Abaixo do peso';
    else if ($paramIMC < 25) 
        return 'Peso normal';
    else if ($paramIMC < 30) 
        return 'Acima do peso';
    else if ($paramIMC < 35) 
        return 'Obesidade grau I';
    else if ($paramIMC < 40) 
        return 'Obesidade grau II';
    return 'Obesidade grau III';
}

?>