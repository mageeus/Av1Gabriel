<?php
require_once("class/class.Login.php");
require_once("class/class.Disciplina.php");
require_once("header.php");
//$obj_login->revalidarLogin();
?>

<body>
    <?php require_once("menu.php"); ?>
    <div class="content">
        <h2>Manutenção de Disciplinas</h2>
        <div>
            <table>
                <tr>
                    <td>IDDISCLIPLINA</td>
                    <td>DSDISCIPLINA</td>
                </tr>
                <?php
                $rows = $disciplina->listarDisciplinas();

                foreach ($rows as $registro) {
                    echo "<tr>";
                    echo "<td><a href=form_disciplina.php?alterarid=" . $registro['iddisciplina'] . ">" . $registro['iddisciplina'];
                    echo "<td>" . $registro['dsdisciplina'] . "</td>";
                    echo "<tr>";
                }
                ?>
            </table>
        </div>
        <div>
            <?php
            if (isset($_GET['alterarid'])) {
                $disciplina = $disciplina->listarDisciplina($_GET['alterarid']);
                ?>
                <form action="form_disciplina.php" method="POST">
                    <input type="hidden" name="iddisciplina" value="<?php echo $disciplina[0]['iddisciplina'] ?>" />
                    <input type="text" name="dsdisciplina" value="<?php echo $disciplina[0]['dsdisciplina'] ?>" maxlength="30" />
                    <input type="submit" value="Alterar" name="comando">
                    <input type="submit" value="Excluir" name="comando">
                </form>
                <?php
            }
            if (isset($_POST['comando']) && $_POST['comando'] == 'Alterar') {
                echo "Comandos para alterar a Disciplina ";
                $disciplina->alterarDisciplina($_POST['iddisciplina'], $_POST['dsdisciplina']);
                header("location:form_disciplina.php?comando=alteracaook");
            } else if (isset($_POST['comando']) && $_POST['comando'] == 'Excluir') {
                echo "Comandos para excluir a Disciplina";
                $disciplina->excluirDisciplina($_POST['iddisciplina']);
                header("location:form_disciplina.php?comando=excluirok");
            } else if (isset($_POST['comando']) && $_POST['comando'] == 'Incluir') {
                echo "Comandos para incluir a Disciplina";
                if (trim($_POST['dsdisciplina']) != '') {
                    echo htmlspecialchars($_POST['dsdisciplina']);
                    $disciplina->incluirDisciplina(htmlspecialchars($_POST['dsdisciplina']));
                    header("location:form_disciplina.php?comando=incluirok");
                }
            }
            ?>
        </div>
        <div>
            <hr>
            <h3>Incluir Disciplina</h3>
            <form action="form_disciplina.php" method="POST">
                <input type="text" name="dsdisciplina" value="" maxlength="30" />
                <input type="submit" value="Incluir" name="comando">
            </form>
        </div>


    </div>



</body>