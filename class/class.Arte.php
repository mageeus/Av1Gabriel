<?php
require_once("class.BancoDeDados.php");

class Arte extends BancoDeDados
{
    public function listArte()
    {
        $list = $this->retornaArray("select * from Arte");

        return $list;
    }
    public function selecionaArte($idArte)
    {
        $arte = $this->retornaArray("select * from Arte where idArte = $idArte");

        return $arte;
    }
    public function listArtePorPessoa($idPessoa)
    {
        $list = $this->retornaArray("select publicacao.idPessoa, publicacao.idPublicacao, arte.arte, arte.idArte from publicacao inner join arte on publicacao.idArte = arte.idArte where publicacao.idPessoa = $idPessoa order by publicacao.data desc");


        // SELECT publicacao.idPessoa, publicacao.idPublicacao, arte.arte, pessoa.username, publicacao.data, publicacao.idArte
        // FROM publicacao
        // INNER JOIN arte ON publicacao.idArte = arte.idArte
        // INNER JOIN pessoa on publicacao.idpessoa = pessoa.idPessoa
        // ORDER BY publicacao.data DESC;
        // select publicacao.idPessoa, publicacao.idPublicacao, arte.arte from publicacao where idPessoa = $idPessoa inner join arte on publicaca.idArte = arte.idArte

        return $list;
    }
    public function InsertArte($idPessoa, $Arte)
    {
        $this->executarConsulta("insert into Arte (idPessoa, Arte, data) values ( $idPessoa , '$Arte', CURRENT_TIMESTAMP)");
        $incluir = $this->retornaArray("select idArte, idPessoa from Arte where data = CURRENT_TIMESTAMP");

        return $incluir;
    }

    public function EditArte($idArte, $Arte)
    {
        $edit = $this->executarConsulta("update Arte set Arte = '$Arte' where idArte = $idArte");

        return $edit;
    }

    public function DeleteArte($idArte)
    {
        $delete = $this->executarConsulta("delete from Arte where idArte = $idArte");

        return $delete;
    }
}

$Arte = new Arte();
