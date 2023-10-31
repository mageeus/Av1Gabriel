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
            <table>
                <tr>
                    <td>idPublicação</td>
                    <td>Pessoa</td>
                    <td>Arte</td>
                    <!--<td>Comentário</td>
                    <td>Comunidade</td>
                    <td>Tag</td>-->
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

                /*
                coisas salvas na sessão:
                    idArte
                    Arte
                    idPessoa
                    Username
                */


                //var_dump($_SESSION);

                foreach ($publicacao as $pub) {
                    echo "<tr>";
                    echo "<td>" . $pub['idPublicacao'] . "</td>";
                    echo "<td>" . $pub['username'] . "</td>";
                    echo "<td>" . "<img class='Arte' src='data:image/*;base64," . base64_encode($pub["arte"]) . "' />" . "</td>";
                    /*echo "<td>" . '' . "</td>";
                    echo "<td>" . '' . "</td>";
                    echo "<td>" . '' . "</td>"; */
                    echo "</tr>";
                    //var_dump($publicacao);
                }
                ?>
            </table>

            <form action="form_publicacao.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idPessoa" value="<?php echo $_SESSION['idPessoa'] ?>" />
                    <input type="file" id="Imagem" name="Imagem" accept="image/png, image/png" required />
                    <input type="submit" value="Criar Publicação" name="comando">
                </form>
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
                //$Arte->InsertArte($_POST['idPessoa'], $blob);
                $idArte = ($Arte->InsertArte($_POST['idPessoa'], $blob)[0]['idArte']);
                //echo $idArte;
                $Publicacao->CriarPublicacao($_SESSION['idPessoa'], $idArte);
                header("location:form_publicacao.php?comando=alteracaook");
            }
            ?>
        </div>
    </div>
</body>