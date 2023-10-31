<?php
require_once("class.BancoDeDados.php");

class Aluno extends BancoDeDados
{
    public function listarAlunosNaoRelacionados()
    {
        $alunoNaoListado = $this->executarConsulta('select * from aluno a where a.idaluno not in (select l.idaluno from login l where l.idaluno = a.idaluno) ');

        return $alunoNaoListado;
    }
    public function listarAlunos()
    {
        $arrayAluno = $this->retornaArray("select * from aluno");

        return $arrayAluno;
    }

    public function listarAluno($idaluno)
    {
        $arrayAluno = $this->retornaArray("select * from aluno where idaluno=" . $idaluno);

        return $arrayAluno;
    }

    public function incluirAluno($nmaluno)
    {
        $incluir = $this->executarConsulta("insert into aluno(nmaluno) values ('$nmaluno')");
        return $incluir;
    }

    public function excluirAluno($idaluno)
    {
        $excluir = $this->executarConsulta("delete from aluno where idaluno =" . $idaluno);
        return $excluir;
    }
    public function alterarAluno($idaluno, $nmaluno)
    {
        $alterar = $this->executarConsulta("update aluno set nmaluno = '" . $nmaluno . "' where idaluno = " . $idaluno);
        return $alterar;
    }
}

$aluno = new Aluno();

//var_dump($aluno->listarAluno(1));
//echo "<br>";
//var_dump($aluno->listarAlunos());
