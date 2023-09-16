<?php
require_once("class/class.Login.php");
require_once("class/class.Pessoa.php");
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
                    <td>idPessoa</td>
                    <td>Nome</td>
                    <td>Username</td>
                    <td>Bio</td>
                    <td>Senha</td>
                    <td>Email</td>
                    <td>Imagem</td>
                    <td>Administrador</td>
                </tr>

                <?php
                ob_start();

                $linha = $Pessoa->selecionaPessoaPorUser($_SESSION['UserName']);

                foreach ($linha as $registro) {
                    echo "<tr>";
                    echo "<td> <a href=form_Pessoa.php?alterarid=" . $registro['idPessoa'] . '>' . $registro['idPessoa'] . "</td>";
                    echo "<td>" . $registro['Nome'] . "</td>";
                    echo "<td>" . $registro['UserName'] . "</td>";
                    echo "<td>" . $registro['Bio'] . "</td>";
                    echo "<td>" . $registro['Email'] . "</td>";
                    echo "<td>" . $registro['Senha'] . "</td>";
                    echo "<td> <a href=form_Pessoa.php?alterarImagem=" . $registro['idPessoa'] . '>' . "<img class='perfil' src='data:image/*;base64," . base64_encode($registro["Imagem"]) . "' />" . "</td>";
                    if ($registro['Administrador'] == 1) {
                        echo "<td>" . "Sim" . "</td>";
                    } else {
                        echo "<td>" . "Não" . "</td>";
                    }
                    echo "</tr>";
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
                    <input type="text" name="Senha" value="<?php echo $selecionaPessoa[0]['Senha'] ?>" maxlength="150" />
                    <input type="submit" value="Alterar" name="comando">
                    <input type="submit" value="Excluir" name="comando">
                </form>

                <?php
            } elseif (isset($_GET['alterarImagem'])) {
                $selecionaPessoa = $Pessoa->listarPessoa($_GET['alterarImagem']);
                ?>
                <form action="form_Pessoa.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idPessoa" value="<?php echo $selecionaPessoa[0]['idPessoa'] ?>" />
                    <input type="file" id="Imagem" name="Imagem" accept="image/png, image/png" required />
                    <input type="submit" value="Alterar Imagem" name="comando">
                    <input type="submit" value="Excluir Imagem" name="comando">
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
                echo "Comandos para alterar o Pessoa ";
                $Pessoa->incluirImagem($_POST['idPessoa'], $blob);
                header("location:form_Pessoa.php?comando=alteracaook");

            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Excluir Imagem') {

                echo "Comandos para alterar o Pessoa ";
                $Pessoa->incluirImagem($_POST['idPessoa'], $blob);
                header("location:form_Pessoa.php?comando=excluirook");

            } elseif (isset($_POST['comando']) && $_POST['comando'] == 'Alterar') {

                echo "Comandos para alterar o Pessoa ";
                $Pessoa->alterarPessoa($_POST['idPessoa'], $_POST['Nome'], $_POST['Email'], $_POST['Senha'], $_POST['Bio']);
                header("location:form_Pessoa.php?comando=alteracaook");

            } /*elseif (isset($_POST['comando']) && $_POST['comando'] == 'Alterar') {

               echo "Comandos para alterar o Pessoa ";
               $Pessoa->alterarUserName($_POST['idPessoa'], $_POST['UserName']);
               header("location:form_Pessoa.php?comando=alteracaook");

           }*/elseif (isset($_POST['comando']) && $_POST['comando'] == 'Excluir') {

                echo "Comandos para excluir o Pessoa";
                $Pessoa->excluirPessoa($_POST['idPessoa']);
                header("location:form_Pessoa.php?comando=excluirok");

            } else if (isset($_POST['comando']) && $_POST['comando'] == 'Incluir') {

                echo "Comandos para incluir o Pessoa";
                if (trim($_POST['Nome']) != '') {

                    echo htmlspecialchars($_POST['Nome']);
                    $Pessoa->incluirPessoa(htmlspecialchars($_POST['Nome']));
                    header("location:form_Pessoa.php?comando=incluirok");
                }
            }

            ?>
        </div>
        <div>
            <hr>
        </div>
    </div>

</body>

</html>