<?php
require_once("class.BancoDeDados.php");

class Pessoa extends BancoDeDados
{
    /*public function listarPessoasNaoRelacionados()
    {
        $PessoaNaoListado = $this->executarConsulta('select * from Pessoa a where a.idPessoa not in (select l.idPessoa from login l where l.idPessoa = a.idPessoa) ');

        return $PessoaNaoListado;
    }*/
    public function listarPessoas()
    {
        $arrayPessoa = $this->retornaArray("select * from Pessoa");

        return $arrayPessoa;
    }
    
    public function listarPessoa($idPessoa)
    {
        $arrayPessoa = $this->retornaArray("select * from Pessoa where idPessoa=" . $idPessoa);

        return $arrayPessoa;
    }

    public function incluirPessoa($Nome)
    {
        $incluir = $this->executarConsulta("insert into Pessoa(Nome) values ('" . $Nome . "')");
        return $incluir;
    }

    public function excluirPessoa($idPessoa)
    {
        $excluir = $this->executarConsulta("delete from Pessoa where idPessoa =" . $idPessoa);
        return $excluir;
    }
    public function alterarPessoa($idPessoa, $Nome)
    {
        $alterar = $this->executarConsulta("update Pessoa set Nome = '" . $Nome . "' where idPessoa = " . $idPessoa);
        return $alterar;
    }
}

$Pessoa = new Pessoa();

//var_dump($Pessoa->listarPessoa(1));
//echo "<br>";
//var_dump($Pessoa->listarPessoas());
