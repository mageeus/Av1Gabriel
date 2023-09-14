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

                $rows = $Pessoa->listarPessoas();


                foreach ($rows as $registro) {
                    echo "<tr>";
                    echo "<td><a href=form_Pessoa.php?alterarid=" . $registro['idPessoa'] . '>' . $registro['idPessoa'] . "</td>";
                    echo "<td>" . $registro['Nome'] . "</td>";
                    echo "<td>" . $registro['UserName'] . "</td>";
                    echo "<td>" . $registro['Bio'] . "</td>";
                    echo "<td>" . $registro['Senha'] . "</td>";
                    echo "<td>" . $registro['Email'] . "</td>";
                    if ($registro['Administrador'] == 1) {
                        echo "<td>" . "Sim" . "</td>";
                    } else {
                        echo "<td>" . "Não" . "</td>";
                    }
                    echo "</tr>";
                    echo "<img src= '" . $registro['Imagem'] . "'>";
                }
                ?>
            </table>
        </div>
        <div>
            <?php
            if (isset($_GET['alterarid'])) {
                $selecionaPessoa = $Pessoa->listarPessoa($_GET['alterarid']);
                ?>
                <form action="form_Pessoa.php" method="POST">
                    <input type="hidden" name="idPessoa" value="<?php echo $selecionaPessoa[0]['idPessoa'] ?>" />
                    <input type="text" name="Nome" value="<?php echo $selecionaPessoa[0]['Nome'] ?>" maxlength="150"
                        required />
                    <input type="submit" value="Alterar" name="comando">
                    <input type="submit" value="Excluir" name="comando">
                </form>

                <?php

            }

            if (isset($_POST['comando']) && $_POST['comando'] == 'Alterar') {
                echo "Comandos para alterar o Pessoa ";
                $Pessoa->alterarPessoa($_POST['idPessoa'], $_POST['Nome']);
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

            <h3>Incluir Pessoa</h3>

            <form action="form_Pessoa.php" method="POST">

                <div class="form-group">
                    <input class="form-control" type="file" name="uploadfile" value="" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" value="Incluir" name="comando">UPLOAD</button>
                </div>
                <!--
                <input type="text" name="Nome" value="" maxlength="150" required />
                <input type="submit" value="Incluir" name="comando">
                -->
            </form>

        </div>
    </div>

</body>

</html>