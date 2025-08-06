<?php
/*Desenvolva um código com a mesma estrutura que o abaixo, porem com os seus dados*/

echo"Olá! \n";
$nome ="Douglas! \n";
$idade ="18" ;
$ano_atual = "2025";

$data_nasc = $ano_atual-$idade;
echo $nome, "você nasceu em:", $data_nasc;

/* 2. Dado uma frase "Programação em php." transformá-la em maiúscula, 
imprima, depois em minúscula e imprima de novo. */ 

    $exerc2= "Programação em php";
    echo "\nMinúsculo: ", $exerc2;
    $exerc2= strtoupper(string: $exerc2);
    echo "\nMaiúsculo: ", $exerc2;
    $exerc2= strtolower(string: $exerc2);
    echo "\nMinúsculo novamente: ", $exerc2;



