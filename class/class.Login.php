<?php
require_once("class.BancoDeDados.php");

class Login extends BancoDeDados
{

    public function validarLogin($Username, $Senha)
    {
        $resultado = $this->executarConsulta("select * from pessoa where Username = '$Username' and Senha = '$Senha'");
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


        if (!isset($_SESSION["Username"]) || !isset($_SESSION["Senha"]) || !isset($_SESSION["token"])) {
            session_destroy();
            header("location:index.php?erro=SEMLOGIN");
        }

        if ($_SESSION["token"] != $token) {
            session_destroy();
            header("location:index.php?erro=INVASAO");
        }

        if (!$this->validarLogin($_SESSION["Username"], $_SESSION["Senha"])) {
            session_destroy();
            header("location:index.php?erro=LOGININVALIDO");
        }
    }
}

$obj_login = new Login();

//var_dump($obj_login->validarLogin('mageus', '123'));