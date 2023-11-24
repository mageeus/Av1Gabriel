<?php
require_once("class/class.Pessoa.php");
require_once("header.php");
?>

<body>

    <?php //require_once("menu.php") ?>

    <form action="proc.login.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idPessoa" value="" />
        <label>Nome: </label>
        <input type="text" name="Nome" value="" maxlength="150" />
        <label>Username: </label>
        <input type="text" name="Username" value="" maxlength="150" />
        <label>Email: </label>
        <input type="text" name="Email" value="" maxlength="150" />
        <label>Senha: </label>
        <input type="password" name="Senha" value="" maxlength="150" />
        <input type="submit" value="Criar" name="comando" />
    </form>

    <?php

    ?>
</body>