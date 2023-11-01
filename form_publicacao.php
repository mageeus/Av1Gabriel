<?php
require_once("class/class.Login.php");
require_once("class/class.Pessoa.php");
require_once("class/class.Arte.php");
require_once("class/class.Publicacao.php");
require_once("header.php");
$obj_login->revalidarLogin();
?>

<body>
    <?php require_once("menu.php") ?>

    <div class="content">
        <h2>Sua Publicacao</h2>
        <div>
            <?php
            if (isset($_POST['comando']) && $_POST['comando'] == 'Criar Publicação') {
                $imagem = $_FILES['Imagem'];
                $info = getimagesize($imagem["tmp_name"]);
                if (!$info) {
                    die("arquivo não é uma imagem");
                }

                $name = $imagem['name'];
                $type = $imagem['type'];

                $blob = addslashes((file_get_contents($imagem["tmp_name"])));

                $idArte = ($Arte->InsertArte($_POST['idPessoa'], $blob)[0]['idArte']);
                $Publicacao->CriarPublicacao($_SESSION['idPessoa'], $idArte);

                header("location:form_publicacao.php?comando=alteracaook");
            } elseif (isset($_GET['idPublicacao'])) {
            ?>
                <form action="form_publicacao.php" method="POST" enctype="multipart/form-data">
                    <input type="file" id="Arte" name="Arte" accept="image/png, image/png" required />
                    <input type="submit" value="Editar Publicação" name="comando">
                    <td> <a href=form_publicacao.php> <input type="button" value="Cancelar"> </td>
                </form>';
                <form action="form_publicacao.php" method="POST" enctype="multipart/form-data">
                    <input type="submit" value="Apagar Publicação" name="comando">
                </form>';

            <?php
                $_SESSION['idArte'] = $_GET['idArte'];
                $_SESSION['idPublicacao'] = $_GET['idPublicacao'];
            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Editar Publicação') {
                $imagem = $_FILES['Arte'];
                $info = getimagesize($imagem["tmp_name"]);

                if (!$info) {
                    die("arquivo não é uma imagem");
                }

                $name = $imagem['name'];
                $type = $imagem['type'];

                $blob = addslashes((file_get_contents($imagem["tmp_name"])));

                $Arte->EditArte($_SESSION['idArte'], $blob);

                header('location:form_publicacao.php');
            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Apagar Publicação') {
                $Publicacao->deletePublicacao($_SESSION['idPublicacao']);
            } else {
            ?>
                <form action="form_publicacao.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idPessoa" value="<?php echo $_SESSION['idPessoa'] ?>" />
                    <input type="file" id="Imagem" name="Imagem" accept="image/png, image/png" required />
                    <input type="submit" value="Criar Publicação" name="comando" />
                </form>
            <?php
            }
            ?>
            <table>
                <tr>
                    <td>idPublicação</td>
                    <td>Pessoa</td>
                    <td>Arte</td>
                    <!-- <td>Comentário</td>
                    <td>Comunidade</td>
                    <td>Tag</td> -->
                </tr>

                <?php
                ob_start();

                $pessoa = $Pessoa->selecionaPessoaPorUser($_SESSION['Username']);
                $arte = $Arte->listArte();
                $publicacao = $Publicacao->listarPublicacao();
                //$comentario = $comentario->listComentario();

                foreach ($pessoa as $dados) {
                    $_SESSION['idPessoa'] = $dados['idPessoa'];
                }

                //var_dump($_SESSION);

                /*
                coisas salvas no SESSION
                    Username;
                    Senha;
                    token;
                    idPessoa; 
                */

                foreach ($publicacao as $pub) {
                    echo "<tr>";
                    echo '<input type="hidden" value=' . $pub['idPessoa'] . '/>';
                    echo "<td>"  . $pub['idPublicacao'] . "</td>";
                    echo "<td>" . $pub['username'] . "</td>";
                    echo "<td>" . "<img class='Arte' src='data:image/*;base64," . base64_encode($pub["arte"]) . "' />" . "</td>";
                    if ($pub['idPessoa'] == $_SESSION['idPessoa']) {
                        echo "<td> <a href=form_publicacao.php?idPublicacao=" . $pub['idPublicacao'] . "&idPessoa=" . $pub['idPessoa'] . '&idArte=' . $pub['idArte'] . ">" . '<input type="button" value="Selecionar" name="comando">' . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>