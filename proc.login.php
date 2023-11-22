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
    header("location:form_criarPessoa.php?erro=username" . $validar->validarNome($_POST["Username"]));
}

if ($validar->validarSenha($_POST["Senha"]) == True) {
    $Senha = md5($_POST["Senha"]);
} else {
    header("location:form_criarPessoa.php?erro=senha" . $validar->validarSenha($_POST["Senha"]));
}

if ($validar->validarEmail($_POST['Email']) == 'email invalido') {
    $Email = $_POST['Email'];
} else {
    header("location:form_criarPessoa.php?erro=email" . $validar->validarEmail($_POST["Email"]));
}

if (isset($_POST["comando"]) && $_POST["comando"] == "Criar" && $Email != Null && $Username != Null && $Senha != Null) {

    $lista = [];

    foreach ($Pessoa->listaUserName() as $username) {
        array_push($lista, $username['Username']);
    }

    //verifica se existe alguem com esse username
    if (!in_array($_POST['Username'], $lista)) {
        $Pessoa->incluirPessoa($_POST['Nome'], $Username, $Email, $Senha);
        header('location:index.php');
    } else {
        header('location:form_criarPessoa.php?erro=UsernameInvalido');
    }
}

if ($obj_login->validarLogin($Username, $Senha)) {
    $token = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

    session_name($token);

    session_start();

    $_SESSION["Username"] = $Username;
    $_SESSION["Senha"] = $Senha;

    $_SESSION["token"] = $token;
    echo "POST: ";
    var_dump($_POST);
    echo "<br>";
    echo "Session: ";
    var_dump($_SESSION);

    header("location:form_pessoa.php");
}
