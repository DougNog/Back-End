<?php

//!=============================!\\
//!Cenário 1 – Viagem pelo Mundo!\\
//!=============================!\\

//*Um grupo de turistas vai visitar o Japão, o Brasil e o Acre. Em cada lugar da
//*Terra, eles poderão comer comidas típicas e nadar em rios ou praias.

//TODO: classes: turistas, lugar, atividade, comida, corpo_agua
//TODO: metodos: visitar, comer, nadar 

class Lugar {
    protected $nome;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
    
    public function comerComidaTipica() {
        echo "Comendo comida típica de {$this->nome}.\n";
    }
    
    public function nadar() {
        echo "Nadando nas águas de {$this->nome}.\n";
    }
}

class Turismo {
    protected $lugares = [];
    
    public function adicionarLugar(Lugar $lugar) {
        $this->lugares[] = $lugar;
    }
    
    public function visitar() {
        foreach ($this->lugares as $lugar) {
            $lugar->comerComidaTipica();
            $lugar->nadar();
        }
    }
}

$turismo = new Turismo();
$turismo->adicionarLugar(new Lugar("Japão"));
$turismo->adicionarLugar(new Lugar("Brasil"));
$turismo->adicionarLugar(new Lugar("Acre"));

$turismo->visitar();

echo "--------------------------------------------------------------------------------\n";

//!================================!\\
//!Cenário 2 – Heróis e Personagens!\\
//!================================!\\

//* Cenário 2 – Heróis e Personagens
//* O Batman, o Superman e o Homem-Aranha estão em uma missão. Eles precisam fazer treinamentos especiais no Cotil e, depois, irão ao shopping para doar brinquedos às crianças.

//TODO Classe = Heróis, Missão
//TODO Métodos = Treinamento, Doar

class Heroi {
    protected $nome;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
    
    public function treinar() {
        echo "{$this->nome} está treinando no Cotil.\n";
    }
    
    public function doarBrinquedos() {
        echo "{$this->nome} está doando brinquedos no shopping.\n";
    }
}

class Missao {
    protected $herois = [];
    
    public function adicionarHeroi(Heroi $heroi) {
        $this->herois[] = $heroi;
    }
    
    public function executarMissao() {
        foreach ($this->herois as $heroi) {
            $heroi->treinar();
            $heroi->doarBrinquedos();
        }
    }
}


$missao = new Missao();
$missao->adicionarHeroi(new Heroi("Batman"));
$missao->adicionarHeroi(new Heroi("Superman"));
$missao->adicionarHeroi(new Heroi("Homem-Aranha"));

$missao->executarMissao();

echo "--------------------------------------------------------------------------------\n";

//!==============================!\\
//!Cenário 3 – Fantasia e Destino!\\
//!==============================!\\

//* John Snow, Papai Smurf, Deadpool e Dexter estão em uma jornada. Durante o caminho, começa a chover, e eles precisam amar uns aos outros para superar as dificuldades. No fim da jornada, eles celebram ao comer juntos.

//TODO Classe = Personagems, Jornada, Clima, Dificuldade
//TODO Métodos = Amar, celebram, comer

class Personagem {
    protected $nome;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
    
    public function amarOutro() {
        echo "{$this->nome} está amando os outros para superar as dificuldades.\n";
    }
    
    public function comerJuntos() {
        echo "{$this->nome} está celebrando e comendo junto com os outros.\n";
    }
}

class Jornada {
    protected $personagens = [];
    
    public function adicionarPersonagem(Personagem $p) {
        $this->personagens[] = $p;
    }
    
    public function enfrentarChuva() {
        foreach ($this->personagens as $p) {
            $p->amarOutro();
        }
    }
    
    public function celebrar() {
        foreach ($this->personagens as $p) {
            $p->comerJuntos();
        }
    }
}


$jornada = new Jornada();
$jornada->adicionarPersonagem(new Personagem("John Snow"));
$jornada->adicionarPersonagem(new Personagem("Papai Smurf"));
$jornada->adicionarPersonagem(new Personagem("Deadpool"));
$jornada->adicionarPersonagem(new Personagem("Dexter"));

echo "Começou a chover...\n";
$jornada->enfrentarChuva();
echo "Celebrando no fim da jornada...\n";
$jornada->celebrar();

echo "--------------------------------------------------------------------------------\n";

//!=============================!\\
//!Cenário 4 – Ciclo da Vida    !\\
//!=============================!\\

//* Na Terra, pessoas podem engravidar, nascer, crescer, fazer escolhas e até doar sangue para ajudar outras.

//TODO Classe = Pessoas, Escolha
//TODO Métodos = Engravidar, nascer, crescer, fazer, doar

class Pessoa {
    protected $nome;
    protected $idade = 0;
    protected $estaGravida = false;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
    
    public function engravidar() {
        if (!$this->estaGravida) {
            $this->estaGravida = true;
            echo "{$this->nome} está grávida.\n";
        } else {
            echo "{$this->nome} já está grávida.\n";
        }
    }
    
    public function nascer() {
        echo "Um novo bebê nasceu!\n";
    }
    
    public function crescer() {
        $this->idade++;
        echo "{$this->nome} cresceu. Agora tem {$this->idade} anos.\n";
    }
    
    public function fazerEscolha($escolha) {
        echo "{$this->nome} fez a escolha: {$escolha}.\n";
    }
    
    public function doarSangue() {
        echo "{$this->nome} doou sangue para ajudar outras pessoas.\n";
    }
}

// Uso
$pessoa = new Pessoa("Maria");
$pessoa->engravidar();
$pessoa->nascer();
$pessoa->crescer();
$pessoa->fazerEscolha("estudar medicina");
$pessoa->doarSangue();

echo "--------------------------------------------------------------------------------\n";

//!=============================!\\
//!Cenário 1 – Viagem pelo Mundo!\\
//!=============================!\\

//* Um sistema de biblioteca deve permitir que usuários (alunos e professores) façam empréstimos de livros e revistas."

//TODO Classe = Alunos, Professores
//TODO Métodos = Emprestimos

class Usuario {
    protected $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function fazerEmprestimo(Emprestimo $emprestimo) {
        echo "{$this->nome} fez um empréstimo do item: {$emprestimo->getItem()->getTitulo()}.\n";
    }
}


class Aluno extends Usuario {

}
class Professor extends Usuario {

}


class ItemBiblioteca {
    protected $titulo;

    public function __construct($titulo) {
        $this->titulo = $titulo;
    }

    public function getTitulo() {
        return $this->titulo;
    }
}


class Livro extends ItemBiblioteca {}
class Revista extends ItemBiblioteca {}

// Classe de empréstimo
class Emprestimo {
    protected $usuario;
    protected $item;

    public function __construct(Usuario $usuario, ItemBiblioteca $item) {
        $this->usuario = $usuario;
        $this->item = $item;
    }

    public function getItem() {
        return $this->item;
    }
}


$aluno = new Aluno("João", 9.5);
$professor = new Professor("Dra. Ana");

$livro = new Livro("Programação em PHP");
$revista = new Revista("Ciência Hoje");

$emprestimo1 = new Emprestimo($aluno, $livro);
$emprestimo2 = new Emprestimo($professor, $revista);

$aluno->fazerEmprestimo($emprestimo1);
$professor->fazerEmprestimo($emprestimo2);

echo "--------------------------------------------------------------------------------\n";

//!=============================!\\
//!Cenário 1 – Viagem pelo Mundo!\\
//!=============================!\\

//* Um sistema de cinema deve permitir que clientes comprem ingressos para sessões de filmes."

//TODO Classe = Clientes
//TODO Métodos = Comprem

class Cliente {
    protected $nome;
    
    public function __construct($nome) {
        $this->nome = $nome;
    }
    
    public function comprarIngresso(Sessao $sessao) {
        echo "{$this->nome} comprou um ingresso para o filme '{$sessao->getFilme()}' às {$sessao->getHorario()}.\n";
    }
}

class Sessao {
    protected $filme;
    protected $horario;
    
    public function __construct($filme, $horario) {
        $this->filme = $filme;
        $this->horario = $horario;
    }
    
    public function getFilme() {
        return $this->filme;
    }
    
    public function getHorario() {
        return $this->horario;
    }
}


$cliente = new Cliente("Carlos");
$sessao = new Sessao("Matrix", "20:00");

$cliente->comprarIngresso($sessao);

echo "--------------------------------------FIM------------------------------------------\n";
?>