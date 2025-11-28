<?php
/**
 ** Arquivo: LivroController.php
 */

require_once __DIR__ . '/../Model/LivroDAO.php';
require_once __DIR__ . '/../Model/Livro.php';

class LivroController {

    private $dao;

    public function __construct() {
        $this->dao = new LivroDAO();
    }

    /**
     * Criar novo livro com validação de duplicidade
     */
    public function criar($titulo, $autor, $ano, $genero, $quantidade) {

        $livro = new Livro($titulo, $autor, $ano, $genero, $quantidade);

        // Recebe o retorno do DAO
        $resultado = $this->dao->criarLivro($livro);

        if ($resultado === "erro_duplicado") {
            return "Erro: já existe um livro com esse título.";
        }

        return "Livro cadastrado com sucesso!";
    }

    public function ler() {
        return $this->dao->lerLivros();
    }

    /**
     * Atualizar livro com validação de duplicidade
     */
    public function atualizar($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {

        $resultado = $this->dao->atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade);

        if ($resultado === "erro_duplicado") {
            return "Erro: já existe outro livro com esse novo título.";
        }

        return "Livro atualizado com sucesso!";
    }

    public function buscarPorTitulo($titulo) {
        return $this->dao->buscarPorTitulo($titulo);
    }

    public function deletar($titulo) {
        $this->dao->excluirLivro($titulo);
        return "Livro removido com sucesso!";
    }
}
?>
