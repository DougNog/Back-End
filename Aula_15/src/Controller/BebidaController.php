<?php
require_once __DIR__ . '/../Model/BebidaDAO.php';
require_once __DIR__ . '/../Model/Bebida.php';

class BebidaController {
    private $dao;

    public function __construct() {
        $this->dao = new BebidaDAO(__DIR__ . '/../../data/bebidas.json');
    }

    // retorna array de Bebida
    public function index() {
        return $this->dao->getAll();
    }

    public function create($nome, $categoria, $volume, $valor, $qtde) {
        $bebida = new Bebida($nome, $categoria, $volume, (float)$valor, (int)$qtde);
        $this->dao->save($bebida);
    }

    public function delete($nome) {
        $this->dao->deleteByName($nome);
    }
}
