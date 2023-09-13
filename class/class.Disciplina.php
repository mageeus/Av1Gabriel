<?php
require_once("class.BancoDeDados.php");

class Disciplina extends BancoDeDados
{
    public function listarDisciplinas()
    {
        $arrayDisciplina = $this->retornaArray("select * from disciplina");

        return $arrayDisciplina;
    }
    public function listarDisciplina($iddisciplina)
    {
        $arrayAluno = $this->retornaArray("select * from disciplina where iddisciplina=" . $iddisciplina);

        return $arrayAluno;
    }
    public function incluirDisciplina($dsdisciplina)
    {
        $incluir = $this->executarConsulta("insert into disciplina(dsdisciplina) values ('". $dsdisciplina ."')");
        return $incluir;
    }
    public function excluirDisciplina($iddisciplina)
    {
        $excluir = $this->executarConsulta("delete from disciplina where iddisciplina = " . $iddisciplina);
        return $excluir;
    }
    public function alterarDisciplina($iddisciplina, $dsdisciplina)
    {
        $alterar = $this->executarConsulta("update disciplina set dsdisciplina = '" . $dsdisciplina . "' where iddisciplina = " . $iddisciplina);
        return $alterar;
    }

}

$disciplina = new Disciplina();
