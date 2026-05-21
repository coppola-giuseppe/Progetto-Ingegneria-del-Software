<?php

class ProspettoPDFConSimulazione extends ProspettoPDFLaureando
{

    public function generaPdfProspettoConSimulazione(FPDF $pdf_save): void
    {
        $this->pdf = $pdf_save;
        parent::generaPdfProspetto();
        $this->aggiungiSimulazione();
    }

    public function aggiungiSimulazione(): void
    {
        if ($this->inf) {
            $carriera = $this->carrieraI;
        } else {
            $carriera = $this->carriera;
        }

        $this->pdf->SetFontSize(10);

        $this->pdf->Ln(3);

        $this->pdf->Cell(0, 5, 'SIMULAZIONE DI VOTO DI LAUREA', 1, 1, 'C');

        $par_t = $this->config::restituisciParametri($carriera->corsoDiStudio)[0];
        $par_c = $this->config::restituisciParametri($carriera->corsoDiStudio)[1];
        list($t_min, $t_max, $t_step) = array_values($par_t);
        list($c_min, $c_max, $c_step) = array_values($par_c);

        $formula = $carriera->formulaVoto;

        $formula = (string)str_replace(
            array('M', 'CFU'),
            array($carriera->media, (int)$carriera->restituisciCFUmedia()),
            $formula
        );

        $parametro = '';
        $colonne = null;
        $righe = null;
        $width_col = null;

        $i_min = 0;
        $i_max = 0;
        $i_step = 0;

        $text = null;

        if ($t_min != 0) {
            $formula = (string)str_replace('C', 0, $formula);
            $parametro = 'T';
            $colonne = ($t_max - $t_min) / $t_step > 7 ? 2 : 1;
            $righe = ceil(($t_max - $t_min + 1) / $t_step / $colonne);
            $width_col = ($this->pdf->GetPageWidth() - 20) / $colonne;

            for ($i = 0; $i < $colonne; $i++) {
                $this->pdf->Cell($width_col / 2, 5, 'VOTO TESI (T)', 1, 0, 'C');
                $this->pdf->Cell($width_col / 2, 5, 'VOTO DI LAUREA', 1, 0, 'C');
            }
            $this->pdf->Ln();

            $i_min = (int)$t_min;
            $i_max = (int)$t_max;
            $i_step = (int)$t_step;

            $text = "scegli voto di tesi, prendi il corrispondente voto di laurea ed arrotonda";
        } elseif ($c_min != 0) {
            $formula = (string)str_replace('T', 0, $formula);


            $parametro = 'C';

            $colonne = ($c_max - $c_min) / $c_step > 7 ? 2 : 1;
            $righe = ceil(($c_max - $c_min + 1) / $c_step / $colonne);
            $width_col = ($this->pdf->GetPageWidth() - 20) / $colonne;

            for ($i = 0; $i < $colonne; $i++) {
                $this->pdf->Cell($width_col / 2, 5, 'VOTO COMMISSIONE (C)', 1, 0, 'C');
                $this->pdf->Cell($width_col / 2, 5, 'VOTO DI LAUREA', 1, 0, 'C');
            }
            $this->pdf->Ln();

            $i_min = (int)$c_min;
            $i_max = (int)$c_max;
            $i_step = (int)$c_step;
            $text = ($this->inf) ? "scegli voto commissione, prendi il corrispondente voto di laurea " . "e somma il voto di tesi tra 1 e 3, quindi arrotonda" : "scegli voto commissione, prendi il corrispondente voto di laurea ed arrotonda";
        }

        $y_cord = $this->pdf->GetY();
        for ($i = $i_min, $col = 0; $col < $colonne && $i <= $i_max; $col++) {
            $this->pdf->SetY($y_cord);
            for ($j = 0; $j < $righe && $i <= $i_max; $j++, $i += $i_step) {
                $this->pdf->SetX(10 + $col * $width_col);
                $formula = trim($formula, '"');

                $val = round(eval('return ' . str_replace($parametro, $i, $formula) . ';'), 3);

                $this->pdf->Cell($width_col / 2, 5, $i, 1, 0, 'C');
                $this->pdf->Cell($width_col / 2, 5, $val, 1, 1, 'C');
            }
        }
        $this->pdf->SetY($y_cord + $righe * 5);
        $this->pdf->Ln(4);

        $this->pdf->MultiCell(0, 5, 'VOTO DI LAUREA FINALE: ' . $text);
    }

}

?>