<?php
require_once("class.BancoDeDados.php");

class Comentario extends BancoDeDados
{
    public function listComentario($idPublicacao)
    {
        $list = $this->retornaArray("
        select Comentario.idComentario, Comentario.IdPublicacao, comentario.comentario, Pessoa.Username        
        from Comentario 
        INNER JOIN Pessoa on Comentario.idPessoa = Pessoa.idPessoa
        where idPublicacao = $idPublicacao
        ");
        
        return $list;
    }
    public function InsertComentario($idPessoa, $idPublicacao, $Comentario)
    {
        $insert = $this->executarConsulta("insert into Comentario (idPessoa, idPublicacao, Comentario, data) values ($idPessoa, $idPublicacao, '$Comentario', CURRENT_TIMESTAMP)");

        return $insert;
    }
    public function UpdateComentario($idComentario, $Comentario)
    {
        $update = $this->executarConsulta("update Comentario set Comentario = '$Comentario' where idComentario = $idComentario");

        return $update;
    }
    public function DeleteComentario($idComentario)
    {
        $delete = $this->executarConsulta("delete from Comentario where idComentario = $idComentario");

        return $delete;
    }
}

$Comentario = new Comentario();
