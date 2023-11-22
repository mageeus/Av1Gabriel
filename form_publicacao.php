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
        
        if (isset($_GET['antes']) && $_GET['antes'] == 'Pessoa') {
            $antes = 'form_pessoa.php';
        } elseif ($_GET['antes'] == 'Feed') {
            $antes = 'form_feed.php';
        }
        
        if (isset($_POST['comando']) && $_POST['comando'] == 'Editar Publicação') {
            $imagem = $_FILES['Arte'];
            $info = getimagesize($imagem["tmp_name"]);
        
            if (!$info) {
                die("arquivo não é uma imagem");
            }
        
            $name = $imagem['name'];
            $type = $imagem['type'];
        
            $blob = addslashes((file_get_contents($imagem["tmp_name"])));
        
            $Arte->EditArte($_SESSION['idArte'], $blob);
        
            header("location:$antes");
        } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Apagar Publicação') {
            $Publicacao->deletePublicacao($_SESSION['idPublicacao']);
            header("location:$antes");
        }

    ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" id="Arte" name="Arte" accept="image/png, image/png" required />
            <input type="submit" value="Editar Publicação" name="comando" />
            <a href="<?php echo $antes ?>"> <input type="button" value="Cancelar" /> </a>
        </form>

        <form method="POST">
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
    // var_dump($_POST['comando']);
    if (isset($_POST["comando"]) && $_POST["comando"] == "Comentar") {
        $Comentario->InsertComentario($_SESSION['idPessoa'], $_GET['idPublicacao'], $_POST['Comentario']);
        unset($_POST['comando']);
    }

    $comentarios = $Comentario->listComentario($_GET['idPublicacao']);

    echo '<div class="Comentario">';
    foreach ($comentarios as $comentario) {
        echo $comentario['Username'] . ': ' . $comentario['comentario'];
        echo '<br>';
    }
    echo '</div>';

    ?>
    <script>
        //remove as coisas da url para impedir reenviar dados ao atualizar
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>