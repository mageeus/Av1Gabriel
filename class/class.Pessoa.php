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
    public function selecionaPessoaPorUser($Username)
    {
        $arrayPessoa = $this->retornaArray("select * from Pessoa where Username='$Username'");

        return $arrayPessoa;
    }

    public function incluirPessoa($Nome, $Username,$Email, $Senha)
    {
        $incluir = $this->executarConsulta("insert into Pessoa(Nome, Username, Email, Senha, data) values ('$Nome', '$Username', '$Email', '$Senha', CURRENT_TIMESTAMP)");
        return $incluir;
    }

    public function incluirImagem($idPessoa, $Imagem)
    {
        $incluir = $this->executarConsulta("update Pessoa set Imagem =  '$Imagem ' where idPessoa = $idPessoa ");
        return $incluir;
    }

    public function excluirPessoa($idPessoa)
    {
        $excluir = $this->executarConsulta("delete from Pessoa where idPessoa = $idPessoa");
        return $excluir;
    }
    public function alterarPessoa($idPessoa, $Nome, $Email, $Senha, $Bio)
    {
        $alterar = $this->executarConsulta("update Pessoa set Nome = '$Nome', Email = '$Email', Senha = '$Senha', Bio = '$Bio' where idPessoa = $idPessoa");
        return $alterar;
    }
    public function alterarUserName($idPessoa, $Username)
    {
        $alterar = $this->executarConsulta("update Pessoa set Username = '$Username' where idPessoa = $idPessoa");
        return $alterar;
    }
    public function excluirImagem($idPessoa)
    {
        $excluir = $this->executarConsulta("update Pessoa set Imagem = '' where idPessoa = $idPessoa");
        return $excluir;
    }
    public function listaUserName()
    {
        $listaUserName = $this->executarConsulta("select idPessoa, Username from Pessoa");
        return $listaUserName;
    }

}

$Pessoa = new Pessoa();

//var_dump($Pessoa->selecionaPessoaPorUser('mageus'));
//echo "<br>";
//var_dump($Pessoa->listarPessoas());
