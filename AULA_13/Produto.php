<?php

// Crie uma classe 'Produtos' com os atributos: código, nome e preço.
// Em seguida, crie a classe ProdutoDAO para a utilização dos métodos CRUD.
// Por fim, desenvolva um arquivo index.php para testar a criação e manipulação dos objetos.
// Implemente também a persistência de dados utilizando o arquivo produtos.json.

// Classe PRODUTOS
class Produtos{
    private $codigo;
    private $nome;
    private $preco;


    public function __construct($codigo, $nome, $preco){
        $this-> codigo = ($codigo);
        $this-> nome = ($nome);
        $this-> preco = ($preco);
    }

    public function setCodigo($codigo){
        $this -> codigo=$codigo;
    }

    public function setNome($nome){
        $this -> nome=$nome;
    }

    public function setPreco($preco){
        $this -> preco=$preco;
    }

    public function getCodigo()
    {
        return $this -> codigo;
    }
    
    public function getNome()
    {
        return $this -> nome;
    }

    public function getPreco()
    {
        return $this -> preco;
    }

}

?>