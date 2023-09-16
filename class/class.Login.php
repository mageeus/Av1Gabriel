<?php
require_once("class.BancoDeDados.php");

class Login extends BancoDeDados
{

    public function listarLogins()
    {
        $listar = $this->executarConsulta("select * from login l left outer join aluno a on l.idaluno = a.idaluno");
        return $listar;
    }
    public function incluirLogin($dslogin, $dssenha, $idaluno)
    {
        $incluir = $this->executarConsulta("insert into login(dslogin, dssenha, idaluno) values ('$dslogin', '$dssenha', $idaluno)");
        return $incluir;
    }

    public function excluirAcesso($dslogin)
    {
        $excluir = $this->executarConsulta("delete from login where dslogin = '" . $dslogin . "'");
        return $excluir;
    }

    public function alterarSenha($dslogin, $dssenha)
    {
        $alterar = $this->executarConsulta("update login set dssenha = '" . $dssenha . "' where dslogin = '" . $dslogin . "'");
        return $alterar;
    }

    public function validarLogin($UserName, $Senha)
    {
        $resultado = $this->executarConsulta("select * from pessoa where UserName = '$UserName' and Senha = '$Senha'");
        $registros = mysqli_num_rows($resultado);
        if ($registros == 1)
            return True;
        return False;
    }

    public function revalidarLogin()
    {
        $token = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

        session_name($token);
        session_start();


        if (!isset($_SESSION["UserName"]) || !isset($_SESSION["Senha"]) || !isset($_SESSION["token"])) {
            session_destroy();
            header("location:index.php?erro=SEMLOGIN");
        }

        if ($_SESSION["token"] != $token) {
            session_destroy();
            header("location:index.php?erro=INVASAO");
        }

        if (!$this->validarLogin($_SESSION["UserName"], $_SESSION["Senha"])) {
            session_destroy();
            header("location:index.php?erro=LOGININVALIDO");
        }
    }
}

$obj_login = new Login();

//var_dump($obj_login->validarLogin('mageus', '123'));