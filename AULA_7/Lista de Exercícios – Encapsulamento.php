<?php

// Criando a Classe Pessoa
class Carro
{
    private $marca;
    private $modelo;
    // Criando construtor para a classe Pessoa
    public function __construct($marca, $modelo)
    {
        $this->setmarca($marca);
        $this->setmodelo($modelo);
    }


    public function setmarca($marca)
    {
        $this->marca = ucwords(strtolower($marca));
    }

    public function getmarca()
    {
        return $this->marca;
    }


    public function setmodelo($modelo)
    {
        $this->modelo = preg_replace('/\D/', '', $modelo);
    }

    public function getmodelo()
    {
        return $this->modelo;
    }
}

$carro1 = new Carro("Chevrolet", "Onix");

//!------------------------------------------------------------------------------!\\

class Pessoa
{
    private $nome;
    private $idade;
    private $email;

    // Criando construtor para a classe Pessoa
    public function __construct($nome, $idade, $email)
    {
        $this->setNome($nome);
        $this->setIdade($idade);
        $this->setemail($email);
    }


    public function setNome($nome)
    {
        $this->nome = ucwords(strtolower($nome));
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setIdade($idade)
    {
        $this->idade = abs((int) $idade);
    }

    public function getIdade()
    {
        return $this->idade;
    }

    public function setemail($email)
    {
        $this->email = abs((int) $email);
    }

    public function getemail()
    {
        return $this->email;
    }


}

$aluno1 = new Pessoa("Douglas Nogueira", "999.999.999-99", "(99) 99999-9999", 20, "emial@gmail.com", "1234");

echo $aluno1->getNome();

//!------------------------------------------------------------------------------!\\
class Aluno
{
    private $nome;
    private $nota;
    // Criando construtor para a classe Pessoa
    public function __construct($nome, $nota)
    {
        $this->setnome($nome);
        $this->setnota($nota);
    }


    public function setnome($nome)
    {
        $this->nome = ucwords(strtolower($nome));
    }

    public function getnome()
    {
        return $this->nome;
    }


    public function setNota(float $nota): void
    {
        if ($nota >= 0 && $nota <= 10) {
            $this->nota = $nota;
        } else {
            $this->nota = 0.0;
        }
    }

    public function getnota()
    {
        return $this->nota;
    }
}

$aluno = new Aluno( "Douglas", 8.5);
echo $aluno->getNome();
echo $aluno->getnota();

//!'------------------------------------------------------------------------------!\\

class Produto {
    private $nome;
    private $preco;
    private $estoque;
    // Criando construtor para a classe Pessoa
    public function __construct($nome, $preco, $estoque)
    {
        $this->setnome($nome);
        $this->setpreco($preco);
        $this->setestoque($estoque);
    }


    public function setnome($nome)
    {
        $this->nome = ucwords(strtolower($nome));
    }

    public function getnome()
    {
        return $this->nome;
    }


    public function setpreco($preco)
    {
        $this->preco = preg_replace('/\D/', '', $preco);
    }

    public function getpreco()
    {
        return $this->preco;
    }

    public function setestoque($estoque)
    {
        $this->estoque = preg_replace('/\D/', '', $estoque);
    }

    public function getestoque()
    {
        return $this->estoque;
    }
}

$produto1 = new Produto("Notebook", "R$ 3.500,00", 50);
echo $produto1->getnome();
echo $produto1->getpreco();
echo $produto1->getestoque();

echo "O produto " . $produto1->getnome() . " custa R$ " . $produto1->getpreco() . " e temos " . $produto1->getestoque() . " unidades em estoque.";

//!'------------------------------------------------------------------------------!\\

class Funcionario {
    private $salario;
    private $nome;
    // Criando construtor para a classe Pessoa
    public function __construct($nome, $salario)
    {
        $this->setnome($nome);
        $this->setsalario($salario);
    }


    public function setnome($nome)
    {
        $this->nome = ucwords(strtolower($nome));
    }

    public function getnome()
    {
        return $this->nome;
    }

    public function setsalario($salario)
    {
        $this->salario = preg_replace('/\D/', '', $salario);
    }

    public function getsalario()
    {
        return $this->salario;
    }
}

$funcionario = new Funcionario("João da Silva", 3500.00);

echo "--- Valores Iniciais ---\n";
echo "Nome: " . $funcionario->getNome() . "\n";
echo "Salário: R$ " . number_format($funcionario->getSalario(), 2, ',', '.') . "\n\n";

// Alterando os valores
$funcionario->setNome("João Silva Junior");
$funcionario->setSalario(4200.50);

echo "--- Valores Após Alteração ---\n";
echo "Novo Nome: " . $funcionario->getNome() . "\n";
echo "Novo Salário: R$ " . number_format($funcionario->getSalario(), 2, ',', '.') . "\n";

?>