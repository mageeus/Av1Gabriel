<?php
require_once("class.BancoDeDados.php");

class Comentario extends BancoDeDados
{
    public function listComentario($idPessoa)
    {
        $list = $this->retornaArray("select * from Comentario where idPessoa = $idPessoa");

        return $list;
    }
    public function InsertComentario($idPessoa, $Comentario)
    {
        $insert = $this->executarConsulta("insert into Comentario (idPessoa, Comentario, data) values ($idPessoa, '$Comentario', CURRENT_TIMESTAMP)");

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
