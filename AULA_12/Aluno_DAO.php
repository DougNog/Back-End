<?php

require_once "Aluno_DAO.php";

class Aluno_DAO
{
    private $alunos = [];
    private $arquivo = "alunos.json";

    public function __construct()
    {
        if (file_exists($this->arquivo)) {
            $conteudo = file_get_contents($this->arquivo);
            $dados = json_decode($conteudo, true);

            if ($dados) {
                foreach ($dados as $id => $info) {
                    $this->alunos[$id] = new Aluno(
                        $info['id'],
                        $info['nome'],
                        $info['curso']
                    );
                }
            }
        }
    }

    private function salvar_em_arquivo()
    {
        $dados = [];

        foreach ($this->alunos as $id => $aluno) {
            $dados[$id] = [
                'id' => $aluno->getId(),
                'nome' => $aluno->getNome(),
                'curso' => $aluno->getCurso()
            ];
        }

        file_put_contents($this->arquivo, json_encode($dados, JSON_PRETTY_PRINT));
    }

    // CREATE
    public function criar_aluno(Aluno $aluno)
    {
        $this->alunos[$aluno->getId()] = $aluno;
        $this->salvar_em_arquivo();
    }

    // READ
    public function ler_aluno()
    {
        return $this->alunos;
    }

    // UPDATE
    public function atualizar_aluno($id, $novoNome, $novoCurso)
    {
        if (isset($this->alunos[$id])) {
            $this->alunos[$id]->setNome($novoNome);
            $this->alunos[$id]->setCurso($novoCurso);
            $this->salvar_em_arquivo();
        }
    }

    // DELETE
    public function excluir_aluno($id)
    {
        if (isset($this->alunos[$id])) {
            unset($this->alunos[$id]);
            $this->salvar_em_arquivo();
        }
    }
}

?>
