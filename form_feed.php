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

    <div class="content">
        <h2>Feed</h2>
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

                header("location:form_feed.php?comando=alteracaook");
            } elseif (isset($_GET['idPublicacao'])) {

                $_SESSION['idArte'] = $_GET['idArte'];
                $_SESSION['idPublicacao'] = $_GET['idPublicacao'];
            }

            ?>
            <form action="form_feed.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idPessoa" value="<?php echo $_SESSION['idPessoa'] ?>" />
                <input type="file" id="Imagem" name="Imagem" accept="image/png, image/png" required />
                <input type="submit" value="Criar Publicação" name="comando" />
            </form>

            <table>
                <tr>
                    <td>idPublicação</td>
                    <td>Pessoa</td>
                    <td>Arte</td>
                </tr>

                <?php
                ob_start();

                $pessoa = $Pessoa->selecionaPessoaPorUser($_SESSION['Username']);
                $publicacao = $Publicacao->listarPublicacao();

                foreach ($pessoa as $dados) {
                    $_SESSION['idPessoa'] = $dados['idPessoa'];
                }

                /*
                coisas salvas no SESSION
                    Username;
                    Senha;
                    token;
                    idPessoa; 
                */

                /*
                coisas salvas na URL
                idPublicacao
                idPessoa
                idArte
                */

                foreach ($publicacao as $pub) {
                    echo "<tr>";
                    echo '<input type="hidden" value=' . $pub['idPessoa'] . '/>';
                    echo "<td>" . $pub['idPublicacao'] . "</td>";
                    echo "<td>" . $pub['username'] . "</td>";
                    echo "<td> <a href=form_publicacao.php?idPublicacao=" . $pub['idPublicacao'] . "&idPessoa=" . $pub['idPessoa'] . '&idArte=' . $pub['idArte'] . "&antes=Feed" . ">" . "<img class='Arte' src='data:image/*;base64," . base64_encode($pub["arte"]) . "' />" . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>