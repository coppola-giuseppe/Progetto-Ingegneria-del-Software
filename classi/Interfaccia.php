<?php

require_once(realpath(dirname(__FILE__)) . '/CarrieraLaureando.php');
require_once(realpath(dirname(__FILE__)) . '/CarrieraLaureandoInformatica.php');
require_once(realpath(dirname(__FILE__)) . '/GeneratoreProspetti.php');
require_once(realpath(dirname(__FILE__)) . '/GestoreInvioEmail.php');

class Interfaccia
{
    public array $_matricole;
    public string $_CdL;
    public string $_data;
    public array $carriere;

    public function __construct($matricole, $cdL, $data)
    {
        $this->_matricole = $matricole;
        $this->_CdL = $cdL;
        $this->_data = $data;
    }

    public function creaProspetti(): bool
    {
        try {
            for ($i = 0; $i < count($this->_matricole); $i++) {
                if ($this->_CdL != "t-inf") {
                    $carrieraLaureando = new CarrieraLaureando($this->_matricole[$i], $this->_CdL, $this->_data);
                    $this->carriere[$i] = $carrieraLaureando;
                } else {
                    $carrieraLaureandoInformatica = new CarrieraLaureandoInformatica(
                        $this->_matricole[$i], $this->_CdL, $this->_data
                    );
                    $this->carriere[$i] = $carrieraLaureandoInformatica;
                }
            }
            $prospetti = new GeneratoreProspetti($this->carriere);
            $prospetti->generaProspettoPDFLaureando();
            $prospetti->generaProspettoPDFCommissione();
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }


    public function inviaProspetti(): bool
    {
        if ($this->_CdL != "t-inf") {
            $carrieraLaureando = new CarrieraLaureando($this->_matricole[0], $this->_CdL, $this->_data);
            $this->carriere[0] = $carrieraLaureando;
        } else {
            $carrieraLaureandoInformatica = new CarrieraLaureandoInformatica(
                $this->_matricole[0], $this->_CdL, $this->_data
            );
            $this->carriere[0] = $carrieraLaureandoInformatica;
        }
        $esito = true;
        $GestoreInvioEmail = new GestoreInvioEmail();
        if (!$GestoreInvioEmail->inviaEmailLaureandi($this->carriere, $this->_CdL, "")) {
            $esito = false;
        }
        return $esito;
    }
}

?>
