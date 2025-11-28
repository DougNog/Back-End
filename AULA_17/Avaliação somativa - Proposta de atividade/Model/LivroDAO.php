<?php //* Início do código PHP

require_once 'Livro.php';       //* Inclui a definição da classe Livro (modelo de dados)
require_once 'Connection.php';  //* Inclui a classe responsável pela conexão com o banco

class LivroDAO { //* Classe de acesso a dados (Data Access Object) para a entidade Livro
    private $conn; //* Propriedade que armazenará o objeto de conexão PDO

    public function __construct() {
        //* Construtor: é chamado ao criar um LivroDAO
        $this->conn = Connection::getInstance();
        //* Obtém a instância de conexão com o banco através do Singleton

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
        //* Garante que exista uma tabela 'livros' com as colunas necessárias.
        //* Se não existir, a tabela é criada.
        //* - id: chave primária autoincremento
        //* - titulo: texto, obrigatório, e único (não podem existir dois livros com o mesmo título)
        //* - autor: texto obrigatório
        //* - ano: inteiro obrigatório
        //* - genero: texto obrigatório
        //* - quantidade: inteiro obrigatório
    }

    public function criarLivro(Livro $livro) {
        //* Insere um novo livro na tabela 'livros'
        $stmt = $this->conn->prepare("
            INSERT INTO livros (titulo, autor, ano, genero, quantidade)
            VALUES (:titulo, :autor, :ano, :genero, :quantidade)
        ");
        //* Prepara um comando SQL com parâmetros nomeados, para evitar SQL Injection

        $stmt->execute([
            ':titulo' => $livro->getTitulo(),       //* Substitui :titulo pelo título do objeto Livro
            ':autor' => $livro->getAutor(),         //* Substitui :autor
            ':ano' => $livro->getAno(),             //* Substitui :ano
            ':genero' => $livro->getGenero(),       //* Substitui :genero
            ':quantidade' => $livro->getQuantidade()//* Substitui :quantidade
        ]);
        //* Executa o comando INSERT com os dados vindos do objeto Livro
    }

    public function lerLivros() {
        //* Lê todos os livros existentes na tabela, ordenados por título
        $stmt = $this->conn->query("SELECT * FROM livros ORDER BY titulo");
        //* Executa uma consulta simples (sem parâmetros) e retorna um PDOStatement

        $result = []; //* Array que armazenará objetos Livro
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //* Percorre cada linha retornada pela consulta como array associativo
            $result[] = new Livro(
                $row['titulo'],      //* Título do livro vindo do banco
                $row['autor'],       //* Autor
                $row['ano'],         //* Ano de publicação
                $row['genero'],      //* Gênero literário
                $row['quantidade']   //* Quantidade disponível
            );
        }
        return $result; //* Retorna um array de objetos Livro
    }

    public function atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        //* Atualiza os dados de um livro identificado pelo título original
        $stmt = $this->conn->prepare("
            UPDATE livros
            SET titulo = :novoTitulo, autor = :autor, ano = :ano, genero = :genero, quantidade = :quantidade
            WHERE titulo = :tituloOriginal
        ");
        //* Comando UPDATE com parâmetros nomeados, para alterar os dados do livro correto

        $stmt->execute([
            ':novoTitulo' => $novoTitulo,         //* Novo título a ser gravado
            ':autor' => $autor,                  //* Novo autor
            ':ano' => $ano,                      //* Novo ano
            ':genero' => $genero,                //* Novo gênero
            ':quantidade' => $quantidade,        //* Nova quantidade
            ':tituloOriginal' => $tituloOriginal //* Título que identifica o livro antigo
        ]);
        //* Executa a atualização no banco de dados
    }

    public function excluirLivro($titulo) {
        //* Exclui um livro com base no título
        $stmt = $this->conn->prepare("DELETE FROM livros WHERE titulo = :titulo");
        //* Prepara o comando DELETE informando o título como filtro
        $stmt->execute([':titulo' => $titulo]);
        //* Executa o DELETE para remover o registro
    }

    public function buscarPorTitulo($titulo) {
        //* Busca um único livro, pelo seu título exato
        $stmt = $this->conn->prepare("SELECT * FROM livros WHERE titulo = :titulo LIMIT 1");
        //* Prepara o comando SELECT com filtro pelo título e limite de 1 registro
        $stmt->execute([':titulo' => $titulo]);
        //* Executa a consulta passando o valor do título

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //* Busca a primeira (e única) linha retornada

        if ($row) {
            //* Se encontrou um registro, cria e retorna um objeto Livro com esses dados
            return new Livro(
                $row['titulo'],
                $row['autor'],
                $row['ano'],
                $row['genero'],
                $row['quantidade']
            );
        }
        return null; //* Se não encontrou, retorna null indicando ausência de livro com esse título
    }
}
?> 
