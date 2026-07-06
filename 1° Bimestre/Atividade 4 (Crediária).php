<?php
    // endereco: http://projetoscti.com.br/projetoscti03/exercphp/andre/crediaria_1.php

    // exercicio 1
    $celsius = 100; //variavel que armazena a temperatura em celsius
    $fahrenheit = $celsius * 1.8 + 32; //variavel que armazena a temperatura em fahrenheit (f = c * 1.8 + 32)
    echo "Temperatura em graus Celsius: ".$celsius."°C<br>";
    echo "<strong>Temperatura em graus Fahrenheit: ".$fahrenheit."°F</strong><br><br>";

    // exercicio 2
    $gramas = 573; //declarando a variavel que armazena a massa em gramas e atribuindo valor
    $quilos = $gramas / 1000; //declarando a variavel que armazena a massa em quilos e convertendo o valor de $gramas para kg (1000g -> 1kg)
    echo "Massa em gramas: ".$gramas."g<br>";
    echo "<strong>Massa em quilos: ".$quilos."Kg</strong><br><br>";

    // exercicio 3 (assuma que o triangulo eh retangulo)
    $base = 10; //variavel que armazena o tamanho da base do triangulo
    $altura = 20; //variavel que armazena a altura do triangulo
    $area = $base * $altura / 2; //variavel que armazena a area do triangulo (formula: (base * altura) / 2)
    echo "Base do triangulo: ".$base."<br>";
    echo "Altura do triangulo: ".$altura."<br>";
    echo "<strong>Area do triangulo: ".$area."</strong><br><br>";

    // exercicio 4
    $salario_hora = 1000; //variavel que armazena o salario por hora
    $horas = 160; //variavel que armazena a qtd de horas trabalhadas em um mes
    $salario_mes = $salario_hora * $horas; //variavel que armazena o salario mensal (salario por hora * qtd de horas trabalhadas em um mes)
    echo "Salario por hora: R$".$area."<br>";
    echo "Qtd de horas trabalhadas em um mes: ".$area." horas<br>";
    echo "<strong>Salario mensal: R$".$salario_mes."</strong>";
?>