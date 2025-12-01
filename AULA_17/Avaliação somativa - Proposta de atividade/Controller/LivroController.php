<?php

require_once __DIR__ . '/../Model/LivroDAO.php';
//! Inclui o arquivo LivroDAO.php, responsável por acessar o banco de dados
//! __DIR__ garante o caminho absoluto do arquivo atual

require_once __DIR__ . '/../Model/Livro.php';
//! Inclui o arquivo Livro.php, que contém a classe Livro (modelo da entidade)

class LivroController {
//! Declaração da classe responsável por controlar as operações de livros

    private $dao;
    //! Atributo privado que armazenará uma instância do DAO (Data Access Object)

    public function __construct() {
        $this->dao = new LivroDAO();
        //* Ao criar o controller, já cria uma instância do LivroDAO
        //* Isso permite acessar métodos de banco de dados
    }

    /**
     *! Criar novo livro com validação de duplicidade
     */
    public function criar($titulo, $autor, $ano, $genero, $quantidade) {
        //* Método público para criar um livro
        //* Recebe os dados necessários como parâmetros

        $livro = new Livro($titulo, $autor, $ano, $genero, $quantidade);
        //* Cria um objeto Livro com os dados recebidos

        //* Recebe o retorno do DAO
        $resultado = $this->dao->criarLivro($livro);
        //* Chama o DAO para salvar o livro no banco
        //* O DAO retorna "erro_duplicado" se já existir um livro com o mesmo título

        if ($resultado === "erro_duplicado") {
            return "Erro: já existe um livro com esse título.";
            //* Caso exista duplicidade, retorna uma mensagem de erro
        }

        return "Livro cadastrado com sucesso!";
        //* Caso tudo dê certo, retorna mensagem positiva
    }

    public function ler() {
        return $this->dao->lerLivros();
        //* Chama o DAO para buscar todos os livros cadastrados
        //* Retorna a lista de livros
    }

    /**
     *! Atualizar livro com validação de duplicidade
     */
    public function atualizar($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        //* Método público para atualizar um livro existente
        //* Recebe o título original e os novos dados

        $resultado = $this->dao->atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade);
        //* Chama o DAO passando os dados da atualização
        //* Pode retornar "erro_duplicado" se mudar para um título já existente

        if ($resultado === "erro_duplicado") {
            return "Erro: já existe outro livro com esse novo título.";
            //* Mensagem de erro se ocorrer duplicidade
        }

        return "Livro atualizado com sucesso!";
        //* Confirma que o livro foi atualizado
    }

    public function buscarPorTitulo($titulo) {
        return $this->dao->buscarPorTitulo($titulo);
        //* Chama o DAO para buscar um livro específico pelo título
    }

    public function deletar($titulo) {
        $this->dao->excluirLivro($titulo);
        //* Solicita ao DAO que delete o livro indicado pelo título

        return "Livro removido com sucesso!";
        //* Retorna mensagem confirmando a exclusão
    }
}

?>