<?php

require_once 'Livro.php';
//* Importa a classe Livro (modelo da entidade)

require_once 'Connection.php';
//* Importa a classe Connection que cria a conexão com o MySQL

class LivroDAO {
//* Declaração da classe responsável por acessar o banco de dados para 'livros'

    private $conn;
    //* Propriedade que armazenará a conexão PDO

    public function __construct() {
        $this->conn = Connection::getInstance();
        //* Obtém a instância única da conexão PDO (Singleton)

        //! Cria a tabela 'livros' caso ela não exista
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS livros (
                id INT AUTO_INCREMENT PRIMARY KEY, //* * id → chave primária auto incrementa
                titulo VARCHAR(200) NOT NULL UNIQUE, //* * título → único (impede duplicidade)
                autor VARCHAR(150) NOT NULL, //* * demais campos obrigatórios
                ano INT NOT NULL, //* * demais campos obrigatórios
                genero VARCHAR(100) NOT NULL, //* * demais campos obrigatórios
                quantidade INT NOT NULL //* * demais campos obrigatórios
            )
        ");

    }

    public function criarLivro(Livro $livro) {
    //* Método responsável por inserir um novo livro no banco

        //* 1. Verificar se já existe um livro com o mesmo título
        $sql = "SELECT COUNT(*) FROM livros WHERE titulo = :titulo";
        //* Consulta que conta quantos livros têm o mesmo título

        $stmt = $this->conn->prepare($sql);
        //* Prepara a consulta SQL

        $stmt->execute([':titulo' => $livro->getTitulo()]);
        //* Executa passando o valor do título usando bind seguro

        if ($stmt->fetchColumn() > 0) {
            //* fetchColumn() retorna o valor da primeira coluna (COUNT(*))
            //* Se for > 0, já existe livro com esse título
            return "erro_duplicado"; 
        }

        //* 2. Inserir o livro no banco
        $stmt = $this->conn->prepare("
            INSERT INTO livros (titulo, autor, ano, genero, quantidade)
            VALUES (:titulo, :autor, :ano, :genero, :quantidade)
        ");
        //* Prepara o comando de inserção

        $stmt->execute([
            ':titulo'     => $livro->getTitulo(),
            ':autor'      => $livro->getAutor(),
            ':ano'        => $livro->getAno(),
            ':genero'     => $livro->getGenero(),
            ':quantidade' => $livro->getQuantidade()
        ]);
        //* Executa passando os valores dos getters do objeto Livro

        return "ok";
        //* Retorna confirmação de sucesso
    }

    public function lerLivros() {
        //* Busca todos os livros ordenados por título
        $stmt = $this->conn->query("SELECT * FROM livros ORDER BY titulo");

        $result = [];
        //* Array que armazenará os objetos Livro retornados

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //* fetch() retorna um registro por vez como array associativo

            $result[] = new Livro(
                $row['titulo'],
                $row['autor'],
                $row['ano'],
                $row['genero'],
                $row['quantidade']
            );
            //* Cria um objeto Livro para cada linha encontrada
        }

        return $result;
        //* Retorna o array de livros
    }

    public function atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        //* Atualiza um livro com validação de duplicidade

        //* Impedir atualização para título que já existe (e não seja o próprio)
        if ($tituloOriginal !== $novoTitulo) {
            //* Se o usuário mudou o título, verificar duplicidade

            $sql = "SELECT COUNT(*) FROM livros WHERE titulo = :novoTitulo";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':novoTitulo' => $novoTitulo]);

            if ($stmt->fetchColumn() > 0) {
                //* Título já existente → erro
                return "erro_duplicado";
            }
        }

        //* Atualiza os campos do livro
        $stmt = $this->conn->prepare("
            UPDATE livros
            SET titulo = :novoTitulo, autor = :autor, ano = :ano, genero = :genero, quantidade = :quantidade
            WHERE titulo = :tituloOriginal
        ");

        //* Executa a atualização com bind seguro
        $stmt->execute([
            ':novoTitulo'     => $novoTitulo,
            ':autor'          => $autor,
            ':ano'            => $ano,
            ':genero'         => $genero,
            ':quantidade'     => $quantidade,
            ':tituloOriginal' => $tituloOriginal
        ]);

        return "ok";
        //* Confirma a atualização
    }

    public function excluirLivro($titulo) {
        //* Excluir livro pelo título
        $stmt = $this->conn->prepare("DELETE FROM livros WHERE titulo = :titulo");
        $stmt->execute([':titulo' => $titulo]);
        //* Não retorna nada; exclusão concluída
    }

    public function buscarPorTitulo($titulo) {
        //* Busca um único livro pelo título
        $stmt = $this->conn->prepare("SELECT * FROM livros WHERE titulo = :titulo LIMIT 1");
        $stmt->execute([':titulo' => $titulo]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //* Obtém o registro encontrado ou false se não houver

        if ($row) {
            //* Se encontrou, retorna um objeto Livro preenchido
            return new Livro(
                $row['titulo'],
                $row['autor'],
                $row['ano'],
                $row['genero'],
                $row['quantidade']
            );
        }

        return null;
        //* Não encontrou o livro -> retorna null
    }
}

?>
