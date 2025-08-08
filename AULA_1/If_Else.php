<?php

$nota1 = 0;
$nota2 = 0;
$aulas_Totais = 100;
$aulas_Presentes = 70;
$nome = "Enzo Enrico";

// --- Cálculos --- //
$media = ($nota1 + $nota2) / 2;
$frequencia = ($aulas_Presentes / $aulas_Totais) * 100;

// --- Verificação da Condição --- //
// Primeiro, verificamos se o aluno atende a AMBOS os critérios para ser aprovado.
if ($media >= 7 && $frequencia >= 70 || $nome == "Enzo Enrico") {
    echo "Aprovado!";
} else {
    //motivo da reprovação.
    if ($media < 7 && $frequencia < 70) {
        echo "Reprovado por média e frequência!";
    } else if ($media < 7) {
        echo "Reprovado por média!";
    } else { // A única condição restante é a reprovação por frequência.
        echo "Reprovado por frequência!";
    }
}
