<?php

require_once(realpath(dirname(__FILE__)) . '/InvioEmailProspetti.php');
require_once(realpath(dirname(__FILE__)) . '/Interfaccia.php');


class GestoreInvioEmail
{

    public function __construct()
    {
    }

    public function inviaEmailLaureandi(array $carriere, string $corsoDiLaurea, string $email_test): bool
    {
        $esito = true;
        $email = new InvioEmailProspetti($carriere[0], $corsoDiLaurea, $email_test);
        if (!$email->inviaEmail()) {
            $esito = false;
        }
        sleep(5);
        return $esito;
    }
}