<?php

//! Crie uma classe "Produtos" com ao menos 4 atributos de utilização de um construtor

class Produtos {
    public $nome;
    public $categoria;
    public $fornecedor;
    public $qtde_estoque;
}

//! Crie a menos 3 objtos para cada classe sem construct

$bolacha1 = new Produtos();
$bolacha1->nome = "passa tempo";
$bolacha1->categoria = "Doces";
$bolacha1->fornecedor = "Nestle";
$bolacha1->qtde_estoque = "150";

$Bebida1 = new Bebidas();
$Bebida1->nome = "Coca-Cola";
$Bebida1->categoria = "Bebidas";
$Bebida1->fornecedor = "Coca-Cola Company";
$Bebida1->qtde_estoque = "300";

$sorvete1 = new Sorvetes();
$sorvete1->nome = "Napolitano";
$sorvete1->categoria = "Sorvetes";
$sorvete1->fornecedor = "Kibon";
$sorvete1->qtde_estoque = "100";





?>