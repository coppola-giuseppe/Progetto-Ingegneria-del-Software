<?php

require_once(realpath(".//lib/PHPMailer/src/Exception.php"));
require_once(realpath(".//lib/PHPMailer/src/PHPMailer.php"));
require_once(realpath(".//lib/PHPMailer/src/SMTP.php"));
require_once(realpath(dirname(__FILE__)) . "/FileDiConfigurazione.php");

use PHPMailer\PHPMailer\PHPMailer;

class InvioEmailProspetti
{

    public FileDiConfigurazione $config;
    public CarrieraLaureando $carriera;
    public string $corsoDiLaurea;
    public string $textEmail;

    public string $email_test;

    public function __construct(CarrieraLaureando $carriera, string $corsoDiLaurea, string $email_test)
    {
        $this->config = FileDiConfigurazione::getConfig();
        $this->carriera = $carriera;
        $this->corsoDiLaurea = $corsoDiLaurea;
        $this->textEmail = $this->config->restituisciTestoEmail($corsoDiLaurea);
        $this->email_test = $email_test;
    }

    public function inviaEmail(): bool
    {
        $esito = true;
        $email = $this->creaEmail();
        if (!$email->Send()) {
            $esito = false;
        }
        $email->SmtpClose();
        unset($email);
        return $esito;
    }

    public function creaEmail(): PHPMailer
    {
        $carriera = $this->carriera;
        $nomeFile = $carriera->nome . "-" . $carriera->cognome . "-" . $carriera->matricola;
        $path = './/prospetti/' . $carriera->corsoDiStudio . '/' . $nomeFile . '.pdf';
        $email = new PHPMailer(true);
        $email->isSMTP();
        $email->Host = "mixer.unipi.it";
        $email->SMTPSecure = "tls";
        $email->SMTPAuth = false;
        $email->Port = 25;

        $email->setFrom('no-reply-laureandosi@ing.unipi.it', 'Laureandosi 2.0');

        // if_else che invia la mail alla mail impostata per i test in caso stia facendo i test

        if ($this->email_test == "") {
            $email->AddAddress($carriera->email);
        } else {
            $email->AddAddress($this->email_test);
        }

        $email->AddAttachment($path, 'report.pdf');

        $email->Subject = 'Appello di laurea in ' . $this->config->restituisciNomeCorso(
                $carriera->corsoDiStudio
            ) . '- indicatori per voto di laurea';
        $email->Body = stripslashes($this->textEmail);
        return $email;
    }

}

?>