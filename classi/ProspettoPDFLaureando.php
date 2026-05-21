<?php

require_once(realpath(dirname(__FILE__)) . '/GeneratoreProspetti.php');
require_once(realpath(dirname(__FILE__)) . '/CarrieraLaureandoInformatica.php');
require_once(realpath(dirname(__FILE__)) . '/CarrieraLaureando.php');
require_once(realpath(dirname(__FILE__)) . "/FileDiConfigurazione.php");
require_once(realpath(".//lib/fpdf184/fpdf.php"));

class ProspettoPDFLaureando
{
    public CarrieraLaureando $carriera;
    public CarrieraLaureandoInformatica $carrieraI;
    public bool $inf;

    public FPDF $pdf;

    public FileDiConfigurazione $config;


    public function __construct(mixed $carr)
    {
        if ($carr->corsoDiStudio == "t-inf") {
            $this->carrieraI = $carr;
            $this->inf = true;
        } else {
            $this->carriera = $carr;
            $this->inf = false;
        }

        $this->pdf = new FPDF('P', 'mm', 'A4');
        $this->config = FileDiConfigurazione::getConfig();
    }


    public function generaPdfProspetto(): void
    {
        if ($this->inf) {
            $carriera = $this->carrieraI;
        } else {
            $carriera = $this->carriera;
        }

        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();
        $cdl = $this->config::restituisciNomeCorso($carriera->corsoDiStudio);
        $this->pdf->Cell(0, 5, $cdl, 0, 1, 'C');
        $this->pdf->Cell(0, 5, 'CARRIERA E SIMULAZIONE DEL VOTO DI LAUREA', 0, 1, 'C');

        $this->prendiAnagrafica();
        $this->prendiCarriera();
        $this->prendiParametriBonus();
    }

    private function prendiAnagrafica(): void
    {
        if ($this->inf) {
            $carriera = $this->carrieraI;
        } else {
            $carriera = $this->carriera;
        }

        $this->pdf->SetFontSize(10);

        $this->pdf->Rect($this->pdf->GetX(), $this->pdf->GetY(), $this->pdf->GetPageWidth() - 20, 5 * (5 + $this->inf));

        $this->pdf->Cell(60, 5, 'Matricola:', 0, 0);
        $this->pdf->Cell(0, 5, $carriera->matricola, 0, 1);
        $this->pdf->Cell(60, 5, 'Nome:', 0, 0);
        $this->pdf->Cell(0, 5, $carriera->nome, 0, 1);
        $this->pdf->Cell(60, 5, 'Cognome:', 0, 0);
        $this->pdf->Cell(0, 5, $carriera->cognome, 0, 1);
        $this->pdf->Cell(60, 5, 'Email:', 0, 0);
        $this->pdf->Cell(0, 5, $carriera->email, 0, 1);
        $this->pdf->Cell(60, 5, 'Data:', 0, 0);
        $this->pdf->Cell(0, 5, $carriera->dataLaurea, 0, 1);
        if ($this->inf) {
            $this->pdf->Cell(60, 5, 'BONUS:', 0, 0);
            $this->pdf->Cell(0, 5, $carriera->bonus ? 'SI' : 'NO', 0, 1);
        }

        $this->pdf->Ln(1.5);
    }

    private function prendiCarriera(): void
    {
        if ($this->inf) {
            $carriera = $this->carrieraI;
        } else {
            $carriera = $this->carriera;
        }

        $this->pdf->SetFontSize(10);

        $this->pdf->Cell($this->pdf->GetPageWidth() - 10 * (5 + $this->inf), 5, 'ESAME', 1, 0, 'C');
        $this->pdf->Cell(10, 5, 'CFU', 1, 0, 'C');
        $this->pdf->Cell(10, 5, 'VOT', 1, 0, 'C');
        $this->pdf->Cell(10, 5, 'MED', 1, 0, 'C');
        if ($this->inf) {
            $this->pdf->Cell(10, 5, 'INF', 1, 0, 'C');
        }
        $this->pdf->Ln();

        $this->pdf->SetFontSize(8);

        foreach ($carriera->esami as $esame) {
            if ($esame->curricolare) {
                $this->pdf->Cell(
                    $this->pdf->GetPageWidth() - 10 * (5 + $this->inf),
                    4,
                    trim($esame->nomeEsame, '"'),
                    1,
                    0
                );
                $this->pdf->Cell(10, 4, $esame->cfuEsame, 1, 0, 'C');
                $this->pdf->Cell(10, 4, $esame->votoEsame, 1, 0, 'C');
                $this->pdf->Cell(10, 4, $esame->faMedia ? 'X' : '', 1, 0, 'C');
                if ($this->inf) {
                    $this->pdf->Cell(10, 4, $esame->informatico ? 'X' : '', 1, 0, 'C');
                }
                $this->pdf->Ln();
            }
        }

        $this->pdf->Ln(3.5);
    }

    private function prendiParametriBonus(): void
    {
        if ($this->inf) {
            $carriera = $this->carrieraI;
        } else {
            $carriera = $this->carriera;
        }

        $this->pdf->SetFontSize(10);

        $this->pdf->Rect($this->pdf->GetX(), $this->pdf->GetY(), $this->pdf->GetPageWidth() - 20, 20 + 10 * $this->inf);

        $this->pdf->Cell(80, 5, 'Media Pesata (M):', 0, 0);
        $this->pdf->Cell(0, 5, round($carriera->media, 3), 0, 1);
        $this->pdf->Cell(80, 5, 'Crediti che fanno media (CFU):', 0, 0);
        $this->pdf->Cell(0, 5, $carriera->restituisciCFUmedia(), 0, 1);
        $this->pdf->Cell(80, 5, 'Crediti curriculari conseguiti:', 0, 0);
        $this->pdf->Cell(
            0,
            5,
            $carriera->restituisciCFU() . '/' . $this->config::restituisciCreditiCorso($carriera->corsoDiStudio),
            0,
            1
        );
        if ($this->inf) {
            $this->pdf->Cell(80, 5, 'Voto di tesi (T):', 0, 0);
            $this->pdf->Cell(0, 5, 0, 0, 1);
        }
        $this->pdf->Cell(80, 5, 'Formula calcolo voto di laurea:', 0, 0);
        $this->pdf->Cell(0, 5, trim($carriera->formulaVoto, '"'), 0, 1);
        if ($this->inf) {
            $this->pdf->Cell(80, 5, 'Media pesata esami INF:', 0, 0);
            $this->pdf->Cell(0, 5, $carriera->mediaEsamiInformatici, 0, 1);
        }
    }

    public function salva(string $directory): void
    {
        $this->pdf->Output('F', $directory);
    }
}

?>