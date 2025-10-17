<?php

class Aluno_DAO
{
    private $alunos = [];


    public function cirar_aluno(Aluno $aluno){
        $this->alunos[$aluno -> getId()] = $aluno;
    }

    public function ler_aluno(){
        return $this->alunos;
    }

    public function atualizar_aluno($id, $novoNome, $novoCurso){
        if (isset($this->alunos[$id])) {
            $this->alunos[$id]->setNome($novoNome);
            $this->alunos[$id]->setCurso($novoCurso);
        }
    }

    public function excluir_aluno($id){
        unset($this->alunos[$id]);
    }
}

?>