<?php
require_once("class/class.Login.php");
require_once("class/class.Pessoa.php");
require_once("header.php");
//$obj_login->revalidarLogin();
?>

<head>
    <!--    <link rel="stylesheet" href="./css/story.css"> -->
</head>

<body>
    <?php require_once("menu.php") ?>
    <h1>Log in</h1>
    <p>｡☆✼★━━━━━━━━━━━━★✼☆｡</p>
    <p>
        <img src="./images/artlovers logo.png">
    </p>
    <p>｡☆✼★━━━━━━━━━━━━★✼☆｡</p>
    <form action="proc.login.php" method="POST">
        <p>
            <label>Usuário:</label>
            <input type="text" name="UserName">
        </p>
        <p>
            <label>Senha:</label>
            <input type="password" name="Senha">
        </p>
        <p>
            <!--<input type="submit" value="Registrar">-->
            <input type="submit" value="Acessar">
        </p>
    </form>
</body>

</html>