<?php
require_once('class.TratamentoDeInput.php');

class ValidacoesDeFormulario extends TratamentoDeInput
{
    const _MAXNOME = 25;
    const _MINNOME = 5;

    const _MAXSENHA = 15; //sem criptografia
    const _MINSENHA = 6; //sem criptografia

    const _MAXEMAIL = 300;
    const _MINEMAIL = 6;

    public function validarNome($Username)
    {
        if (parent::caracterInvalido($Username) == True) {
            if (strlen($Username) > self::_MAXNOME) {
                return False; //apenas para verificar o erro certo, dps mudar para False
            }
            if (strlen($Username) < self::_MINNOME) {
                return False; //apenas para verificar o erro certo, dps mudar para False
            }
            return 'caracter invalido';
        }
        return True;
    }

    public function validarEmail($email)
    {
        if (parent::caracterInvalido($email) == True) {
            if (strlen($email) > self::_MAXEMAIL) {
                return False;
            }
            if (strlen($email) < self::_MINEMAIL) {
                return False;
            }
            return False;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) != True) {
            return False;
        } else {
            return True;
        }
    }
    public function validarSenha($senha)
    {
        if (parent::caracterInvalido($senha) == True) {
            if (strlen($senha) > self::_MAXSENHA) {
                return False;                       //apenas para verificar o erro certo, dps mudar para False
            }

            if (strlen($senha) < self::_MINSENHA) {
                return False;                       //apenas para verificar o erro certo, dps mudar para False
            }

            return 'caracter invalido';
        }
        return True;
    }
}

$validar = new ValidacoesDeFormulario();
/*
echo 'nome valido: ', var_dump($validar->validarNome('mateus')), '<br>';
echo 'nome invalido: ', var_dump($validar->validarNome('mateus<')), '<br>';

echo '</br>';

echo 'email valido: ', var_dump($validar->validarEmail('mateus@gmail.com')), '</br>';
echo 'email invalido: ', var_dump($validar->validarEmail('mateus')), '</br>';

echo '<br>';

echo 'senha valida: ', var_dump($validar->validarSenha('senhaComplicada')), '</br>';
echo 'senha invalida: ', var_dump($validar->validarSenha('senha>')), '</br>';
*/