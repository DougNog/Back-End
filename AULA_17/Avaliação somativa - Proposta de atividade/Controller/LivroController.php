<?php
require_once __DIR__ . '/../Model/LivroDAO.php';
require_once __DIR__ . '/../Model/Livro.php';

class LivroController {
    private $dao;

    public function __construct() {
        $this->dao = new LivroDAO();
    }

    public function criar($titulo, $autor, $ano, $genero, $quantidade) {
        $livro = new Livro($titulo, $autor, $ano, $genero, $quantidade);
        $this->dao->criarLivro($livro);
    }

    public function ler() {
        return $this->dao->lerLivros();
    }

    public function atualizar($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        $this->dao->atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade);
    }

    public function buscarPorTitulo($titulo) {
        return $this->dao->buscarPorTitulo($titulo);
    }

    public function deletar($titulo) {
        $this->dao->excluirLivro($titulo);
    }
}
?>