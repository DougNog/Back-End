<?php

require_once 'Livro.php';
require_once 'Connection.php';

class LivroDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS livros (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(200) NOT NULL UNIQUE,
                autor VARCHAR(150) NOT NULL,
                ano INT NOT NULL,
                genero VARCHAR(100) NOT NULL,
                quantidade INT NOT NULL
            )
        ");
    }

    public function criarLivro(Livro $livro) {

        // 1. Verificar se já existe um livro com o mesmo título
        $sql = "SELECT COUNT(*) FROM livros WHERE titulo = :titulo";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':titulo' => $livro->getTitulo()]);

        if ($stmt->fetchColumn() > 0) {
            return "erro_duplicado"; 
        }

        // 2. Inserir o livro no banco
        $stmt = $this->conn->prepare("
            INSERT INTO livros (titulo, autor, ano, genero, quantidade)
            VALUES (:titulo, :autor, :ano, :genero, :quantidade)
        ");

        $stmt->execute([
            ':titulo'     => $livro->getTitulo(),
            ':autor'      => $livro->getAutor(),
            ':ano'        => $livro->getAno(),
            ':genero'     => $livro->getGenero(),
            ':quantidade' => $livro->getQuantidade()
        ]);

        return "ok";
    }

    public function lerLivros() {
        $stmt = $this->conn->query("SELECT * FROM livros ORDER BY titulo");

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Livro(
                $row['titulo'],
                $row['autor'],
                $row['ano'],
                $row['genero'],
                $row['quantidade']
            );
        }
        return $result;
    }

    public function atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {

        // Impedir atualizar para um título que já existe (e não seja o próprio)
        if ($tituloOriginal !== $novoTitulo) {
            $sql = "SELECT COUNT(*) FROM livros WHERE titulo = :novoTitulo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':novoTitulo' => $novoTitulo]);

            if ($stmt->fetchColumn() > 0) {
                return "erro_duplicado";
            }
        }

        $stmt = $this->conn->prepare("
            UPDATE livros
            SET titulo = :novoTitulo, autor = :autor, ano = :ano, genero = :genero, quantidade = :quantidade
            WHERE titulo = :tituloOriginal
        ");

        $stmt->execute([
            ':novoTitulo'     => $novoTitulo,
            ':autor'          => $autor,
            ':ano'            => $ano,
            ':genero'         => $genero,
            ':quantidade'     => $quantidade,
            ':tituloOriginal' => $tituloOriginal
        ]);

        return "ok";
    }

    public function excluirLivro($titulo) {
        $stmt = $this->conn->prepare("DELETE FROM livros WHERE titulo = :titulo");
        $stmt->execute([':titulo' => $titulo]);
    }

    public function buscarPorTitulo($titulo) {
        $stmt = $this->conn->prepare("SELECT * FROM livros WHERE titulo = :titulo LIMIT 1");
        $stmt->execute([':titulo' => $titulo]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Livro(
                $row['titulo'],
                $row['autor'],
                $row['ano'],
                $row['genero'],
                $row['quantidade']
            );
        }

        return null;
    }
}

?>
