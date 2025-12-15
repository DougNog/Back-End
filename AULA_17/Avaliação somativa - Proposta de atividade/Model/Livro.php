<?php

class Livro {
    //* Declara a classe Livro.
    //* Esta classe representa o MODEL no padrão MVC, ou seja, a entidade "Livro" do sistema.

    private $titulo;
    //* Propriedade privada que armazena o título do livro.

    private $autor;
    //* Propriedade privada que armazena o autor do livro.

    private $ano;
    //* Propriedade privada que armazena o ano de publicação do livro.

    private $genero;
    //* Propriedade privada que armazena o gênero do livro.

    private $quantidade;
    //* Propriedade privada que armazena a quantidade de exemplares disponíveis.

    public function __construct($titulo, $autor, $ano, $genero, $quantidade){
        //* Método construtor da classe.
        //* É executado automaticamente quando um objeto Livro é criado (new Livro).

        $this->titulo = $titulo;
        //* Atribui o valor recebido no parâmetro $titulo à propriedade $titulo do objeto.

        $this->autor = $autor;
        //* Atribui o autor recebido à propriedade $autor do objeto.

        $this->ano = $ano;
        //* Atribui o ano recebido à propriedade $ano do objeto.

        $this->genero = $genero;
        //* Atribui o gênero recebido à propriedade $genero do objeto.

        $this->quantidade = $quantidade;
        //* Atribui a quantidade recebida à propriedade $quantidade do objeto.
    }

    public function getTitulo() { return $this->titulo; }
    //* Método getter que retorna o valor da propriedade $titulo.

    public function setTitulo($titulo) { 
        $this->titulo = $titulo; 
        return $this; 
    }
    //* Método setter que altera o valor do título.
    //* Retorna o próprio objeto ($this) para permitir encadeamento de métodos (method chaining).

    public function getAutor() { return $this->autor; }
    //* Getter que retorna o autor do livro.

    public function setAutor($autor) { 
        $this->autor = $autor; 
        return $this; 
    }
    //* Setter que define o autor do livro e retorna o próprio objeto.

    public function getAno() { return $this->ano; }
    //* Getter que retorna o ano de publicação.

    public function setAno($ano) { 
        $this->ano = $ano; 
        return $this; 
    }
    //* Setter que define o ano de publicação e retorna o próprio objeto.

    public function getGenero() { return $this->genero; }
    //* Getter que retorna o gênero do livro.

    public function setGenero($genero) { 
        $this->genero = $genero; 
        return $this; 
    }
    //* Setter que define o gênero do livro e retorna o próprio objeto.

    public function getQuantidade() { return $this->quantidade; }
    //* Getter que retorna a quantidade disponível do livro.

    public function setQuantidade($quantidade) { 
        $this->quantidade = $quantidade; 
        return $this; 
    }
    //* Setter que define a quantidade disponível e retorna o próprio objeto.
}
?>
