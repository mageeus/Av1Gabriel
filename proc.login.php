<?php
if (!isset($_POST["dslogin"]) || !isset($_POST["dssenha"])) {
    header("location:index.php?erro=ACESSOILEGAL");
}
require_once("class\class.Login.php");
require_once("class\class.ValidacoesDeFormulario.php");

if ($validar->validarNome($_POST["dslogin"]) == "ok") {
    $login = $_POST["dslogin"];
} else {
    header("location:index.php?erro=" . $validar->validarNome($_POST["dslogin"]));
}


if ($validar->validarSenha($_POST["dssenha"]) == "ok") {
    $senha = md5($_POST["dssenha"]);
} else {
    header("location:index.php?erro=" . $validar->validarSenha($_POST["dssenha"]));
}

//echo($obj_login->revalidarLogin());
if ($obj_login->validarLogin($login, $senha)) {
    $token = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

    session_name($token);

    session_start();

    $_SESSION["login"] = $login;
    $_SESSION["senha"] = $senha;

    $_SESSION["token"] = $token;

    header("location:welcome.php");
} else {

    header("location:index.php?erro=NAOLOCALIZADO");
}
