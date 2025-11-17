<?php

namespace Aula_16;

use Aula_16\Bebidas as Aula_16Bebidas;
use Bebidas;
use PDO;


require_once 'Bebidas.php';
require_once 'Connection.php';


class BebidaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Cria a tabela se não existir
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS bebidas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL UNIQUE,
                categoria VARCHAR(50) NOT NULL,
                volume VARCHAR(20) NOT NULL,
                valor DECIMAL(10,2) NOT NULL,
                qtde INT NOT NULL
            )
        ");
    }
    

    // CREATE
    public function criarBebida(Aula_16Bebidas $bebida) {
        $stmt = $this->conn->prepare("
            INSERT INTO bebidas (nome, categoria, volume, valor, qtde)
            VALUES (:nome, :categoria, :volume, :valor, :qtde)
        ");
        $stmt->execute([
            ':nome' => $bebida->getNome(),
            ':categoria' => $bebida->getCategoria(),
            ':volume' => $bebida->getVolume(),
            ':valor' => $bebida->getValor(),
            ':qtde' => $bebida->getQtde()
        ]);
    }

    // READ
    public function lerBebidas() {
        $stmt = $this->conn->query("SELECT * FROM bebidas ORDER BY nome");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Aula_16Bebidas(
                $row['nome'],
                $row['categoria'],
                $row['volume'],
                $row['valor'],
                $row['qtde']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarBebida($nomeOriginal, $novoNome, $categoria, $volume, $valor, $qtde) {
        $stmt = $this->conn->prepare("
            UPDATE bebidas
            SET nome = :novoNome, categoria = :categoria, volume = :volume, valor = :valor, qtde = :qtde
            WHERE nome = :nomeOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':categoria' => $categoria,
            ':volume' => $volume,
            ':valor' => $valor,
            ':qtde' => $qtde,
            ':nomeOriginal' => $nomeOriginal
        ]);
    }

    // DELETE
    public function excluirBebida($nome) {
        $stmt = $this->conn->prepare("DELETE FROM bebidas WHERE nome = :nome");
        $stmt->execute([':nome' => $nome]);
    }

    // BUSCAR POR NOME
    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM bebidas WHERE nome = :nome LIMIT 1");
        $stmt->execute([':nome' => $nome]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Aula_16Bebidas(
                $row['nome'],
                $row['categoria'],
                $row['volume'],
                $row['valor'],
                $row['qtde']
            );
        }
        return null;
    }
}