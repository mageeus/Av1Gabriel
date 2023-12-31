<?php
require_once("class/class.Login.php");
require_once("class/class.Pessoa.php");
require_once("class/class.Arte.php");
require_once("header.php");
$obj_login->revalidarLogin();
?>

<body>

    <?php require_once("menu.php") ?>

    <div class="content">
        <h2>Seu Perfil</h2>
        <div>
            <table>
                <tr>
                    <!-- <td>idPessoa</td> -->
                    <td>Nome</td>
                    <td>Username</td>
                    <td>Bio</td>
                    <td>Email</td>
                    <td>Imagem</td>
                </tr>

                <?php
                ob_start();
                $linha = $Pessoa->selecionaPessoaPorUser($_SESSION['Username']);

                foreach ($linha as $registro) {
                    echo "<tr>";
                    echo "<td>" . $registro['Nome'] . "</td>";
                    echo "<td>" . $registro['UserName'] . "</td>";
                    echo "<td>" . $registro['Bio'] . "</td>";
                    echo "<td>" . $registro['Email'] . "</td>";
                    echo "<td> <a href=form_Pessoa.php?alterarImagem=" . $registro['idPessoa'] . '>' . "<img class='perfil' src='data:image/*;base64," . base64_encode($registro["Imagem"]) . "' />" . "</td>";
                    echo "<td> <a href=form_Pessoa.php?alterarid=" . $registro['idPessoa'] . ">" . "<input type='button' value='Editar Perfil'/>" . "</td>";
                    /* if ($registro['Administrador'] == 1) {
                        echo "<td>" . "Sim" . "</td>";
                    } else {
                        echo "<td>" . "Não" . "</td>";
                    }*/
                    echo "</tr>";

                    //echo "<a href=form_Pessoa.php?alterarid=" . $registro['idPessoa'] . ">  ";

                    $_SESSION['idPessoa'] = $registro['idPessoa'];
                }
                ?>
            </table>
        </div>
        <div>
            <?php
            if (isset($_GET['alterarid'])) {
                $selecionaPessoa = $Pessoa->listarPessoa($_GET['alterarid']);

                ?>
                <form action="form_Pessoa.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idPessoa" value="<?php echo $selecionaPessoa[0]['idPessoa'] ?>" />
                    <label>Nome: </label>
                    <input type="text" name="Nome" value="<?php echo $selecionaPessoa[0]['Nome'] ?>" maxlength="150" />
                    <label>Bio: </label>
                    <input type="text" name="Bio" value="<?php echo $selecionaPessoa[0]['Bio'] ?>" maxlength="150" />
                    <label>Email: </label>
                    <input type="text" name="Email" value="<?php echo $selecionaPessoa[0]['Email'] ?>" maxlength="150" />
                    <label>Senha: </label>
                    <input type="password" name="Senha" value="<?php echo $selecionaPessoa[0]['Senha'] ?>" maxlength="150" />
                    <input type="submit" value="Alterar" name="comando" />
                    <input type="submit" value="Excluir" name="comando" />
                </form>

                <?php
            } elseif (isset($_GET['alterarImagem'])) {
                $selecionaPessoa = $Pessoa->listarPessoa($_GET['alterarImagem']);
                ?>
                <form action="form_Pessoa.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idPessoa" value="<?php echo $selecionaPessoa[0]['idPessoa'] ?>" />
                    <input type="file" id="Imagem" name="Imagem" accept="image/png, image/png" required />
                    <input type="submit" value="Alterar Imagem" name="comando" />
                    <input type="submit" value="Excluir Imagem" name="comando" />
                </form>
                <?php
            }


            if (isset($_POST['comando']) && $_POST['comando'] == 'Alterar Imagem') {
                $imagem = $_FILES['Imagem'];
                $info = getimagesize($imagem["tmp_name"]);
                if (!$info) {
                    die("arquivo não é uma imagem");
                }

                $name = $imagem['name'];
                $type = $imagem['type'];

                $blob = addslashes((file_get_contents($imagem["tmp_name"])));
                $Pessoa->incluirImagem($_POST['idPessoa'], $blob);
                header("location:form_Pessoa.php?comando=alteracaook");

            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Excluir Imagem') {

                $Pessoa->incluirImagem($_POST['idPessoa'], $blob);
                header("location:form_Pessoa.php?comando=excluirook");

            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Alterar') {

                $Pessoa->alterarPessoa($_POST['idPessoa'], $_POST['Nome'], $_POST['Email'], md5($_POST['Senha']), $_POST['Bio']);
                header("location:form_Pessoa.php?comando=alteracaook");

            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Excluir') {

                $Pessoa->excluirPessoa($_POST['idPessoa']);
                header("location:form_Pessoa.php?comando=excluirok");

            }

            ?>
        </div>
        <div>
            <table>
                <td>Artes</td>

                <?php 
                ob_start();
                $artes = $Arte->listArtePorPessoa($_SESSION['idPessoa']);

                foreach($artes as $arte){
                    echo "<tr>";
                    echo "<td> <a href=form_publicacao.php?idArte=". $arte['idArte'] . "&idPublicacao=" . $arte['idPublicacao'] . "&idPessoa=" . $arte['idPessoa'] . "&antes=Pessoa" . ">" . "<img class='perfil' src='data:image/*;base64," . base64_encode($arte["arte"]) . "' />" . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>