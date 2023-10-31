<?php
require_once("class.BancoDeDados.php");

class Publicacao extends BancoDeDados
{
    public function listarPublicacao()
    {
        $arrayPublicacao = $this->retornaArray("
        SELECT publicacao.idPublicacao, arte.arte, pessoa.username, publicacao.data
        FROM publicacao
        INNER JOIN arte ON publicacao.idArte = arte.idArte
        inner join pessoa on publicacao.idpessoa = pessoa.idPessoa");

        return $arrayPublicacao;
    }

    public function editarPublicacao($idPublicacao, $idArte)
    {
        $editaPublicacao = $this->executarConsulta("update Publicacao set idArte = $idArte where idPublicacao = $idPublicacao");

        return $editaPublicacao;
    }

    public function CriarPublicacao($idPessoa, $idArte)
    {
        $incluir = $this->executarConsulta("insert into Publicacao (idPessoa, idArte, data) values ($idPessoa, $idArte, CURRENT_TIMESTAMP)");

        return $incluir;
    }
}

$Publicacao = new Publicacao();

//var_dump($Publicacao->CriarPublicacao(5,2));