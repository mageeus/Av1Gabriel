<?php
require_once("class/class.Pessoa.php");
require_once("header.php");
?>

<body>

    <?php require_once("menu.php") ?>

    <form action="form_criarPessoa.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idPessoa" value="" />
        <label>Nome: </label>
        <input type="text" name="Nome" value="" maxlength="150" />
        <label>UserName: </label>
        <input type="text" name="UserName" value="" maxlength="150" />
        <label>Email: </label>
        <input type="text" name="Email" value="" maxlength="150" />
        <label>Senha: </label>
        <input type="password" name="Senha" value="" maxlength="150" />
        <input type="submit" value="Criar" name="comando">
    </form>

    <?php
    if (isset($_POST["comando"]) && $_POST["comando"] == "Criar") {

        $lista = [];

        foreach ($Pessoa->listaUserName() as $username) {
            array_push($lista, $username['UserName']);
        }


        if (!in_array($_POST['UserName'], $lista)) {
            $Pessoa->incluirPessoa($_POST['Nome'], $_POST['UserName'], $_POST['Email'], $_POST['Senha']);
            header('location:index.php');
        } else {
            echo 'Username já está sendo utilizado.';
        }

        /*
        //verifica se existe alguem com esse username
        foreach ($Pessoa->listaUserName() as $key => $value) {
            if ($value['UserName'] == $_POST['UserName']) {
                //não existe alguem com esse Username
                //$Pessoa->incluirPessoa($_POST['Nome'], $_POST['UserName'], $_POST['Email'], $_POST['Senha']);         
                //header('location:index.php');
                echo "Username já utilizado";
            } else {
                //existe alguem com esse Username
                echo 'oiii';
            }

        }
*/

    }
    ?>
</body>