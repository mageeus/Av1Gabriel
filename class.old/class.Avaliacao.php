<?php
require_once("class.BancoDeDados.php");

class Avaliacao extends BancoDeDados
{

    public function listarAvaliacao($idavaliacao)
    {
        $listar = $this->retornaArray("select * from avaliacao where idavaliacao = " . $idavaliacao);
        return $listar;
    }
    public function listarAvaliacoes()
    {
        $listar = $this->executarConsulta("select * from avaliacao av left outer join aluno a on av.idaluno = a.idaluno left join disciplina d on av.iddisciplina = d.iddisciplina");
        
        return $listar;
    }

    public function incluirAvaliacao($idaluno, $iddisciplina, $nota)
    {
        $incluir = $this->executarConsulta("insert into avaliacao(idaluno, iddisciplina, nota) values($idaluno, $iddisciplina, $nota)");
        return $incluir;
    }

    public function alterarAvaliacao($idavaliacao, $nota)
    {
        $alterar = $this->executarConsulta("update avaliacao set nota = '" . $nota . "' where idavaliacao = " . $idavaliacao);
        return $alterar; 
    }

    public function excluirAvaliacao($idavaliacao)
    {
        $excluir = $this->executarConsulta("delete from avaliacao where idavaliacao = " . $idavaliacao);
        return $excluir;
    }
}

$avaliacao = new Avaliacao();