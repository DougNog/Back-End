<?php

$numero = 5;

$diaDaSemana = '';

switch ($numero) {
    case 1:
        $diaDaSemana = "Domingo";
        break;
    case 2:
        $diaDaSemana = "Segunda-feira";
        break;
    case 3:
        $diaDaSemana = "Terça-feira";
        break;
    case 4:
        $diaDaSemana = "Quarta-feira";
        break;
    case 5:
        $diaDaSemana = "Quinta-feira";
        break;
    case 6:
        $diaDaSemana = "Sexta-feira";
        break;
    case 7:
        $diaDaSemana = "Sábado";
        break;
    default:
        $diaDaSemana = "Número inválido. Por favor, use um valor de 1 a 7.";
        break;
}

echo "O número " . $numero . " corresponde a: " . $diaDaSemana . "\n";

?>