<?php

require_once 'Livro.php';
//* Inclui o arquivo Livro.php apenas uma vez.
//* Garante que a classe Livro (Model) esteja disponível para uso neste arquivo.

require_once 'Connection.php';
//* Inclui o arquivo Connection.php apenas uma vez.
//* Permite usar a classe Connection para obter a conexão com o banco de dados.

class LivroDAO {
    //* Declara a classe LivroDAO (Data Access Object).
    //* Esta classe é responsável por TODAS as operações de banco de dados relacionadas a livros.

    private $conn;
    //* Propriedade privada que armazenará a conexão PDO com o banco de dados.

    public function __construct() {
        //* Método construtor da classe.
        //* É executado automaticamente quando um objeto LivroDAO é criado.

        $this->conn = Connection::getInstance();
        //* Obtém a instância única da conexão com o banco (Singleton)
        //* e armazena na propriedade $conn.

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
        //* Executa um comando SQL que cria a tabela 'livros' caso ela ainda não exista.
        //* id: chave primária com auto incremento
        //* titulo: texto único (impede livros duplicados pelo título)
        //* autor, ano, genero, quantidade: campos obrigatórios
    }

    public function criarLivro(Livro $livro) {
        //* Método responsável por inserir um novo livro no banco.
        //* Recebe um objeto Livro como parâmetro (tipagem garante o tipo correto).

        try {
            //* Inicia bloco try para capturar erros de banco de dados.

            $stmt = $this->conn->prepare("
                INSERT INTO livros (titulo, autor, ano, genero, quantidade)
                VALUES (:titulo, :autor, :ano, :genero, :quantidade)
            ");
            //* Prepara a instrução SQL de INSERT usando parâmetros nomeados
            //* para evitar SQL Injection.

            $stmt->execute([
                ':titulo' => $livro->getTitulo(),
                //* Obtém o título do objeto Livro e associa ao parâmetro :titulo.

                ':autor' => $livro->getAutor(),
                //* Obtém o autor do objeto Livro.

                ':ano' => $livro->getAno(),
                //* Obtém o ano do objeto Livro.

                ':genero' => $livro->getGenero(),
                //* Obtém o gênero do objeto Livro.

                ':quantidade' => $livro->getQuantidade()
                //* Obtém a quantidade do objeto Livro.
            ]);

            return true;
            //* Retorna true se o livro foi inserido com sucesso.

        } catch (PDOException $e) {
            //* Captura qualquer erro ocorrido durante o INSERT.

            if ($e->getCode() == 23000) {
                //* Código 23000 indica violação de integridade (ex: UNIQUE).
                return "Erro: já existe um livro cadastrado com esse título.";
            }

            return "Erro ao cadastrar livro.";
            //* Retorna mensagem genérica para outros erros.
        }
    }

    public function lerLivros() {
        //* Método responsável por buscar TODOS os livros cadastrados.

        $stmt = $this->conn->query("SELECT * FROM livros ORDER BY titulo");
        //* Executa uma consulta SQL que retorna todos os livros ordenados pelo título.

        $result = [];
        //* Cria um array vazio para armazenar os objetos Livro.

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //* Percorre cada linha retornada pela consulta.
            //* FETCH_ASSOC retorna os dados como array associativo.

            $result[] = new Livro(
                $row['titulo'],
                //* Passa o título da linha para o construtor do Livro.

                $row['autor'],
                //* Passa o autor.

                $row['ano'],
                //* Passa o ano.

                $row['genero'],
                //* Passa o gênero.

                $row['quantidade']
                //* Passa a quantidade.
            );
            //* Cada registro do banco vira um objeto Livro.
        }

        return $result;
        //* Retorna o array de objetos Livro.
    }

    public function atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        //* Método responsável por atualizar um livro existente.
        //* $tituloOriginal identifica o livro a ser alterado.

        $stmt = $this->conn->prepare("
            UPDATE livros
            SET titulo = :novoTitulo, autor = :autor, ano = :ano, genero = :genero, quantidade = :quantidade
            WHERE titulo = :tituloOriginal
        ");
        //* Prepara a instrução SQL UPDATE com parâmetros nomeados.

        try {
            //* Inicia bloco try para capturar erros.

            $stmt->execute([
                ':novoTitulo' => $novoTitulo,
                //* Novo título do livro.

                ':autor' => $autor,
                //* Novo autor.

                ':ano' => $ano,
                //* Novo ano.

                ':genero' => $genero,
                //* Novo gênero.

                ':quantidade' => $quantidade,
                //* Nova quantidade.

                ':tituloOriginal' => $tituloOriginal
                //* Título original usado como critério de atualização.
            ]);

            return true;
            //* Retorna true se a atualização foi bem-sucedida.

        } catch (PDOException $e) {
            //* Captura erros durante o UPDATE.

            if ($e->getCode() == 23000) {
                //* Erro de duplicidade de título (campo UNIQUE).
                return "Erro: já existe um livro com esse título.";
            }

            return "Erro ao atualizar livro.";
            //* Retorna mensagem genérica para outros erros.
        }
    }

    public function excluirLivro($titulo) {
        //* Método responsável por excluir um livro pelo título.

        $stmt = $this->conn->prepare("DELETE FROM livros WHERE titulo = :titulo");
        //* Prepara o comando SQL DELETE usando parâmetro nomeado.

        $stmt->execute([':titulo' => $titulo]);
        //* Executa o DELETE substituindo o parâmetro pelo título informado.
    }

    public function buscarPorTitulo($titulo) {
        //* Método responsável por buscar UM livro pelo título.

        $stmt = $this->conn->prepare("SELECT * FROM livros WHERE titulo = :titulo LIMIT 1");
        //* Prepara uma consulta SQL para buscar um único livro pelo título.

        $stmt->execute([':titulo' => $titulo]);
        //* Executa a consulta substituindo o parâmetro pelo título informado.

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //* Busca a primeira linha do resultado como array associativo.

        if ($row) {
            //* Verifica se algum registro foi encontrado.

            return new Livro(
                $row['titulo'],
                //* Título do livro encontrado.

                $row['autor'],
                //* Autor.

                $row['ano'],
                //* Ano.

                $row['genero'],
                //* Gênero.

                $row['quantidade']
                //* Quantidade.
            );
            //* Retorna um objeto Livro preenchido com os dados do banco.
        }

        return null;
        //* Retorna null se nenhum livro com o título informado for encontrado.
    }
}