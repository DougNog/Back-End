<?php
/*
=========================================
  TechFit - Conexão com Banco de Dados
  Ambiente: XAMPP Localhost
  Banco: techfit
  Autor: Douglas Nogueira (Ajinomoto)
=========================================
*/

$host = "localhost";     // Servidor local do XAMPP
$user = "root";          // Usuário padrão do MySQL local
$pass = "senaisp";              // Senha vazia (padrão no XAMPP)
$db   = "techfit";       // Nome do banco criado com techfit_schema.sql

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica erro de conexão
if ($conn->connect_error) {
    echo"Erro";
}else{
    echo"Sucesso";
}

// Mensagem opcional de debug (pode deixar comentado em produção)
// echo "Conexão com o banco de dados TechFit realizada com sucesso!";

?>
    