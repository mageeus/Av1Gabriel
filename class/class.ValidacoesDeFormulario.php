<?php
require_once('class.TratamentoDeInput.php');

class ValidacoesDeFormulario extends TratamentoDeInput
{
    const _MAXNOME = 20;
    const _MINNOME = 5;

    const _MAXSENHA = 15; //sem criptografia
    const _MINSENHA = 6; //sem criptografia

    const _MAXEMAIL = 300;
    const _MINEMAIL = 6;

    public function validarNome($nome)
    {
        if (parent::caracterInvalido($nome) == true) {
            if (strlen($nome) > self::_MAXNOME) {
                return false; //apenas para verificar o erro certo, dps mudar para false
            }
            if (strlen($nome) < self::_MINNOME) {
                return false; //apenas para verificar o erro certo, dps mudar para false
            }
            return 'caracter invalido';
        }
        return 'ok';
    }

    public function validarEmail($email)
    {
        if (parent::caracterInvalido($email) == true) {
            if (strlen($email) > self::_MAXEMAIL) {
                return 'muito longo';
            }
            if (strlen($email) < self::_MINEMAIL) {
                return 'muito curto';
            }
            return 'caracter invalido';
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return 'email invalido';
        } else {
            return 'ok';
        }
    }
    public function validarSenha($senha)
    {
        if (parent::caracterInvalido($senha) == true) {
            if (strlen($senha) > self::_MAXSENHA) {
                return false; //apenas para verificar o erro certo, dps mudar para false
            }

            if (strlen($senha) < self::_MINSENHA) {
                return false; //apenas para verificar o erro certo, dps mudar para false
            }

            return 'caracter invalido';
        }
        return 'ok';
    }

}

$validar = new ValidacoesDeFormulario();

echo 'nome valido: ', var_dump($validar->validarNome('mateus')), '<br>';
echo 'nome invalido: ', var_dump($validar->validarNome('mateus<')), '<br>';

echo '</br>';

echo 'email valido: ', var_dump($validar->validarEmail('mateus@gmail.com')), '</br>';
echo 'email invalido: ', var_dump($validar->validarEmail('mateus')), '</br>';

echo '<br>';

echo 'senha valida: ', var_dump($validar->validarSenha('senhaComplicada')), '</br>';
echo 'senha invalida: ', var_dump($validar->validarSenha('senha>')), '</br>';
