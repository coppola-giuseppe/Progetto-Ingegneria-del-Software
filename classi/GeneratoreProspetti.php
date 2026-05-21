<?php

require_once(realpath(dirname(__FILE__)) . '/ProspettoPDFLaureando.php');
require_once(realpath(dirname(__FILE__)) . '/ProspettoPDFCommissione.php');
require_once(realpath(dirname(__FILE__)) . "/FileDiConfigurazione.php");

class GeneratoreProspetti
{

    public array $carriere;

    public function __construct(array $carr)
    {
        $this->carriere = $carr;
    }

    public function generaProspettoPDFLaureando(): void
    {
        for ($i = 0; $i < count($this->carriere); $i++) {
            $carriera = $this->carriere[$i];
            $prospettoL = new ProspettoPDFLaureando($carriera);
            $prospettoL->generaPdfProspetto();
            $path = './/.//.//prospetti/' . $carriera->corsoDiStudio . '/';
            //crea la cartella se il path non esiste
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $nomeFile = $carriera->nome . "-" . $carriera->cognome . "-" . $carriera->matricola;
            $prospettoL->salva($path . DIRECTORY_SEPARATOR . $nomeFile . '.pdf');
        }
    }

    public function generaProspettoPDFCommissione(): void
    {
        $prospettoC = new ProspettoPDFCommissione($this->carriere);
        $prospettoC->generaProspettoCommissione();
        $path = './/.//.//prospetti/' . $this->carriere[0]->corsoDiStudio . '/';
        $nomeFile = $this->carriere[0]->corsoDiStudio . "-all";
        $prospettoC->salva($path . DIRECTORY_SEPARATOR . $nomeFile . '.pdf');
    }

}

?>