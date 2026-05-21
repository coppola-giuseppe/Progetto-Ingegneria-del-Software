<?php

require_once(realpath(dirname(__FILE__)) . '/ProspettoPDFConSimulazione.php');
require_once(realpath(dirname(__FILE__)) . "/FileDiConfigurazione.php");
require_once(realpath(".//lib/fpdf184/fpdf.php"));

class ProspettoPDFCommissione
{

    public array $carriere;
    public FPDF $pdf_all;
    public FileDiConfigurazione $config;

    public function __construct(mixed $carr)
    {
        $this->carriere = $carr;
        $this->config = FileDiConfigurazione::getConfig();
    }

    public function generaProspettoCommissione(): void
    {
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetFont('Arial', '', 10);
        $pdf->AddPage();
        $cdl = $this->config::restituisciNomeCorso($this->carriere[0]->corsoDiStudio);
        $pdf->Cell(0, 5, $cdl, 0, 1, 'C');
        $pdf->Ln();
        $text = "LAUREANDOSI 2 - Progettazione: mario.cimino@unipi.it, Amministrazione: rose.rossiello@unipi.it";
        $pdf->Cell(0, 5, $text, 0, 1, 'C');
        $pdf->Ln();
        $pdf->Cell(0, 5, 'LISTA LAUREANDI', 0, 1, 'C');
        $pdf->Ln();
        $width = ($pdf->GetPageWidth() - 20) / 4;
        $pdf->Cell($width, 6, 'COGNOME', 1, 0, 'C');
        $pdf->Cell($width, 6, 'NOME', 1, 0, 'C');
        $pdf->Cell($width, 6, 'CDL', 1, 0, 'C');
        $pdf->Cell($width, 6, 'VOTO LAUREA', 1, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);

        foreach ($this->carriere as $carriera) {
            $pdf->Cell($width, 6, $carriera->cognome, 1, 0, 'C');
            $pdf->Cell($width, 6, $carriera->nome, 1, 0, 'C');
            $pdf->Cell($width, 6, "", 1, 0, 'C');
            $pdf->Cell($width, 6, "/110", 1, 0, 'C');
            $pdf->Ln();
        }


        for ($i = 0; $i < count($this->carriere); $i++) {
            $prospettoC = new ProspettoPDFConSimulazione($this->carriere[$i]);
            $prospettoC->generaPdfProspettoConSimulazione($pdf);
            $pdf = $prospettoC->pdf;
        }
        $this->pdf_all = $pdf;
    }

    public function salva(string $directory): void
    {
        $this->pdf_all->Output('F', $directory);
    }

}


?>