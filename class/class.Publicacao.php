<?php
require_once("class.BancoDeDados.php");
require_once("class.Arte.php");

class Publicacao extends BancoDeDados
{
    public function listarPublicacao()
    {
        $arrayPublicacao = $this->retornaArray("
        SELECT publicacao.idPessoa, publicacao.idPublicacao, arte.arte, pessoa.username, publicacao.data, publicacao.idArte
        FROM publicacao
        INNER JOIN arte ON publicacao.idArte = arte.idArte
        INNER JOIN pessoa on publicacao.idpessoa = pessoa.idPessoa
        ORDER BY publicacao.data DESC;
        ");

        /*
        , comentario.comentario
        LEFT JOIN comentario on publicacao.idPublicacao = comentario.idPublicacao
        */
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

    public function selecionaPublicacao($idPublicacao)
    {
        $seleciona = $this->retornaArray("select * from publicacao where idPublicacao = $idPublicacao");

        return $seleciona;
    }

    public function deletePublicacao($idPublicacao)
    {
        $delete = $this->executarConsulta("delete from Publicacao where idPublicacao = $idPublicacao");

        return $delete;
    }
}

$Publicacao = new Publicacao();

//var_dump($Publicacao->CriarPublicacao(5,2));