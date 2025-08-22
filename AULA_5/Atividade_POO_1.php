<?php

//! Após a conclusão dos exercícios 1 e 2, crie uma classe chamada 'Usuario' com os
//!atributos: Nome, CPF, Sexo, Email, Estado civil, Cidade, Estado, Endereco e CEP.

class Usuario
{
    public $nome;

    public $cpf;

    public $sexo;

    public $email;

    public $estadoCivil;

    public $cidade;

    public $estado;

    public $endereco;

    public $cep;

    public function __construct($nome, $cpf, $sexo, $email, $estadoCivil, $cidade, $estado, $endereco, $cep)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->sexo = $sexo;
        $this->email = $email;
        $this->estadoCivil = $estadoCivil;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->endereco = $endereco;
        $this->cep = $cep;
    }

    //! Exercício 7:
//! Crie um metodo para a classe Usuarios chamado de 'Testando Reservista' 
//!no qual testa se o usuario é homem e caso sim exiba uma mensagem "Apresente seu certificado de reservista do tiro de guerra!", caso não, exiba uma mensagem "Tudo certo"

    public function TestandoReservista()
    {
        if (
            $this->sexo == "Masculino"
        ) {
            echo "Apresente seu certificado de reservista";
        } else {
            echo "Tudo certo";
        }

    }

    //! Exercicio 8
//! Crie um metodo para a classe 'Usuarios' chamado de 'Casamento' que teste se o estado civil é igual a 'Casado 
//!e caso sim exiba a mensagem "Parabens pelo seu casamento de $anos_casado anos!" e caso não, exiba uma mensagem de "Oloco". 
//!O valor de anos de casamento será informado na hora de chamar o método para o objeto em específico.

    public function casamento($anos_casado)
    {
        if (
            $this->estadoCivil == "Casado"
        ) {
            echo "Parabens pelo seu casamento de $anos_casado anos! \n";
        } else {
            echo "Oloco \n";
        }
    }

}

$usuario1 = new Usuario(
    "Josenildo Afonso Souza",
    "100.200.300-40",
    "Masculino",
    "josenewdo.souza@gmail.com",
    "Casado",
    "Xique-Xique",
    "Xique-Xique",
    "Rua da amizade, 99",
    "40123-98"
);

$usuario2 = new Usuario(
    "Valentina Passos Scherrer",
    "070.070.060-70",
    "Feminino",
    "scherrer.valen@outlook.com",
    "Divorciada",
    "Iracemápolis",
    "São Paulo",
    "Avenida da saudade, 1942",
    "23456-24"
);

$usuario3 = new Usuario(
    "Claudio Braz Nepumoceno",
    "575.575.242-32",
    "Masculino",
    "Clauclau.nepumoceno@gmail.com",
    "Solteiro",
    "Piripiri",
    "Piauí",
    "Estrada 3, 33",
    "12345-99"
);

$usuario1 -> casamento(10)

?>