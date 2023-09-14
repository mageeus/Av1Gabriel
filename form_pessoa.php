<?php
require_once("class/class.Login.php");
require_once("class/class.Pessoa.php");
require_once("header.php");
//$obj_login->revalidarLogin();
?>

<body>

    <?php require_once("menu.php") ?>

    <div class="content">
        <h2>Manutenção de Pessoa</h2>
        <div>
            <table>
                <tr>
                    <td>idPessoa</td>
                    <td>Nome</td>
                    <td>Username</td>
                    <td>Bio</td>
                    <td>Senha</td>
                    <td>Email</td>
                    <td>Administrador</td>
                </tr>

                <?php
                ob_start();
                $rows = $Pessoa->listarPessoas();


                foreach ($rows as $registro) {
                    echo "<tr>";
                    echo "<td><a href=form_Pessoa.php?alterarid=" . $registro['idPessoa'] . '>' . $registro['idPessoa'] . "</td>";
                    echo "<td>" . $registro['Nome'] . "</td>";
                    echo "<td>" . $registro['UserName'] . "</td>";
                    echo "<td>" . $registro['Bio'] . "</td>";
                    echo "<td>" . $registro['Senha'] . "</td>";
                    echo "<td>" . $registro['Email'] . "</td>";
                    echo "<td> <img src='data:image/*;base64," . base64_encode($registro["Imagem"]) . "' /> <td>";
                    if ($registro['Administrador'] == 1) { echo "<td>" . "Sim" . "</td>"; } else { echo "<td>" . "Não" . "</td>"; }
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
                    <input type="text" name="Nome" value="<?php echo $selecionaPessoa[0]['Nome'] ?>" maxlength="150" required />
                    <input type="file" id="Imagem" name="Imagem" accept="image/png, image/png" />
                    <input type="submit" value="Alterar" name="comando">
                    <input type="submit" value="Excluir" name="comando">
                </form>

                <?php
            }


            if (isset($_POST['comando']) && $_POST['comando'] == 'Alterar') {

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

            } else if (isset($_POST['comando']) && $_POST['comando'] == 'Excluir') {

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