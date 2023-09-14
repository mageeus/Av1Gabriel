<?php
require_once("class/class.Login.php");
require_once("class/class.Aluno.php");
require_once("class/class.Avaliacao.php");
require_once("class/class.Disciplina.php");
require_once("header.php");
//$obj_login->revalidarLogin();
?>

<body>

    <?php require_once("menu.php") ?>

    <div class="content">
        <br />
        <table>
            <tr>
                <td>idavaliacao</td>
                <td>nmaluno</td>
                <td>dsdisciplina</td>
                <td>nota</td>
            </tr>
            <?php

            $registros = $avaliacao->listarAvaliacoes();

            foreach ($registros as $linha) {
                echo '<tr>';
                echo '    <td>    <a href=form_avaliacao.php?alterar=' . $linha['idavaliacao'] . '>' . $linha['idavaliacao'] . '</a> </td>';
                echo '    <td>' . $linha['nmaluno'] . '</td>';
                echo '    <td>' . $linha['dsdisciplina'] . '</td>';
                echo '    <td>' . $linha['nota'] . '</td>';
                echo '</tr>';
            }

            ?>
        </table>
        <?php
        if (isset($_GET['alterar'])) {
            $seleciona = $avaliacao->listarAvaliacao($_GET['alterar']);
            $selecionaAluno = $aluno->listarAluno($seleciona[0]['idaluno']);
            $selecionaDisciplina = $disciplina->listarDisciplina($seleciona[0]['iddisciplina']);
        ?>
            <hr>
            <form action="form_avaliacao.php" method="POST">
                Aluno: <input name="nmaluno" type="text" readonly value="<?php echo $selecionaAluno[0]['nmaluno'] ?>">
                Disciplina: <input name="nmaluno" type="text" readonly value="<?php echo $selecionaDisciplina[0]['dsdisciplina'] ?>">
                Nota: <input name="nota" type="number" max="10" value="<?php echo $seleciona[0]['nota'] ?>" />
                <input type="hidden" name="idavaliacao" value=" <?php echo $seleciona[0]['idavaliacao'] ?>" />
                <input type="submit" name="comando" value="alterar" />
                <input type="submit" name="comando" value="excluir" />
            </form>
        <?php } ?>
        <hr>
        ÁREA PRA REGISTRAR NOTAS
        <hr>
        <form action="form_avaliacao.php" method="POST">
            <select name="idaluno">
                <?php $registrosAluno = $aluno->listarAlunos();
                foreach ($registrosAluno as $linha) {
                    echo "<option value='" . $linha['idaluno'] . "'>" . $linha['nmaluno'] . "</option>";
                }
                ?>
            </select>
            <select name="iddisciplina">
                <?php $registrosDisciplina = $disciplina->listarDisciplinas();
                foreach ($registrosDisciplina as $linha) {
                    echo "<option value='" . $linha['iddisciplina'] . "'>" . $linha['dsdisciplina'] . "</option>";
                }
                ?>
            </select>
            Nota: <input name="nota" type="number" max="10" required />
            <input type="submit" name="comando" value="registrar" />
        </form>

        <?php
        if (isset($_POST['comando']) && ($_POST['comando'] == "registrar")) {
            $idaluno = $_POST['idaluno'];
            $iddisciplina = $_POST['iddisciplina'];
            $nota = $_POST['nota'];

            if ($avaliacao->incluirAvaliacao($idaluno, $iddisciplina, $nota)) {
                header("location:form_avaliacao.php");
            }
        } else if (isset($_POST['comando']) && ($_POST['comando'] == "alterar")) {
            $avaliacao->alterarAvaliacao($_POST['idavaliacao'], $_POST['nota']);
            header("location:form_avaliacao.php");
        } else if (isset($_POST['comando']) && ($_POST['comando'] == "excluir")) {
            $avaliacao->excluirAvaliacao($_POST['idavaliacao']);
            header("location:form_avaliacao.php");
        }
        ?>

    </div>

</body>