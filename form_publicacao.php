<?php
require_once("class/class.Login.php");
require_once("class/class.Pessoa.php");
require_once("class/class.Arte.php");
require_once("class/class.Publicacao.php");
require_once("class/class.Comentario.php");

require_once("header.php");
$obj_login->revalidarLogin();
?>

<body>
    <?php require_once("menu.php") ?>

    <h2>Publicação</h2>

    <?php
    if (isset($_GET['idPessoa']) && $_SESSION['idPessoa'] == $_GET['idPessoa']) {
        $_SESSION['idPublicacao'] = $_GET['idPublicacao'];
        $_SESSION['idArte'] = $_GET['idArte'];

    ?>
        <form action="form_feed.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="Arte" name="Arte" accept="image/png, image/png" required />
            <input type="submit" value="Editar Publicação" name="comando" />
            <a href=form_feed.php> <input type="button" value="Cancelar" /> </a>
        </form>

        <form action="form_feed.php" method="POST">
            <input type="submit" value="Apagar Publicação" name="comando" />
        </form>

    <?php
    }
    $arte = $Arte->selecionaArte($_GET['idArte'])[0]['Arte'];
    echo "<img class='post' src='data:image/*;base64," . base64_encode($arte) . "' /> </br>";
    ?>
    <form method='POST'>
        <input type='text' name='Comentario' />
        <input type="submit" value="Comentar" name="comando" />
    </form>
    <?php
    if (isset($_POST["comando"]) && $_POST["comando"] == "Comentar") {
        $Comentario->InsertComentario($_SESSION['idPessoa'], $_GET['idPublicacao'], $_POST['Comentario']);
    }

    $comentarios = $Comentario->listComentario($_GET['idPublicacao']);

    echo '<div class="Comentario">';
    foreach ($comentarios as $comentario) {
        echo $comentario['Username'] . ': ' . $comentario['comentario'];
        echo '<br>';
    }
    echo '</div>';
    ?>

</body>