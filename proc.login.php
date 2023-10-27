<?php
if (!isset($_POST["Username"]) || !isset($_POST["Senha"])) {
    header("location:index.php?erro=ACESSOILEGAL");
}
require_once("class\class.Login.php");
require_once("class\class.Pessoa.php");
require_once("class\class.ValidacoesDeFormulario.php");

if ($validar->validarNome($_POST["Username"]) == True) {
    $Username = $_POST["Username"];
} else {
    header("location:index.php?erro=" . $validar->validarNome($_POST["Username"]));
}

if ($validar->validarSenha($_POST["Senha"]) == true) {
    $Senha = /*md5*/($_POST["Senha"]);
} else {
    header("location:index.php?erro=" . $validar->validarSenha($_POST["Senha"]));
}
//var_dump($_POST);
/*
$Username = $_POST['Username'];
$Senha = $_POST['Senha'];*/

echo ($obj_login->revalidarLogin());

if ($obj_login->validarLogin($Username, $Senha)) {
    $token = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

    session_name($token);

    session_start();

    // $_POST['Username'] = $Username;
    // $_POST['Senha'] = $Senha;

    $_SESSION["Username"] = $Username;
    $_SESSION["Senha"] = $Senha;

    $_SESSION["token"] = $token;
    echo "POST: ";
    var_dump($_POST);
    echo "<br>";
    echo "Session: ";
    var_dump($_SESSION);

    header("location:form_pessoa.php");
} else {
    /*    
        echo "<br>";
        var_dump($_SESSION);
        echo "<br>";*/
    //var_dump($_POST);

    header("location:index.php?erro=NAOLOCALIZADO");
}