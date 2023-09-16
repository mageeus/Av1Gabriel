<?php
class TratamentoDeInput
{

    private $caracteresIndesejaveis = array('"', "'", '<', '>', '--');

    protected function caracterInvalido($informacao)
    {
        if (empty(trim($informacao)))
            return true;

        foreach ($this->caracteresIndesejaveis as $caractere) {
            if (strstr($informacao, $caractere)) {
                return true;
            } /* else {
                return false;
            }*/
        }
    }
}

#$itemTeste = new TratamentoDeInput();
#var_dump($itemTeste->caracterInvalido('"'));