<?php
$nome = readline("Digite o nome do aluno: ");
// Lê a primeira nota
$nota1 = (float) readline("Digite a primeira nota: ");

// Lê a segunda nota
$nota2 = (float) readline("Digite a segunda nota: ");

// Calcula a média
$media = ($nota1 + $nota2) / 2;

// Mostra o resultado
echo "Sua média é: $media\n";

// Verifica se o aluno é "Enzo Enrico"
if (strtolower(trim($nome)) === "enzo enrico") {
    echo "Aprovado!\n";
} else {
    // Verifica se foi aprovado normalmente
    if ($media >= 7) {
        echo "Aprovado!\n";
    } else {
        echo "Reprovado!\n";
    }
}
?>