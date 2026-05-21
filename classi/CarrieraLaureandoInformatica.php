<?php

require_once(realpath(dirname(__FILE__)) . '/CarrieraLaureando.php');

class CarrieraLaureandoInformatica extends CarrieraLaureando
{

    public bool $bonus;
    public float $mediaEsamiInformatici;

    public function __construct(int $matricola, string $cdl, string $dataLaurea)
    {
        parent::__construct($matricola, $cdl, $dataLaurea);

        $carriera_string = GestioneCarrieraStudente::restituisciCarrieraStudente($matricola);
        $dataImmatricolazione = json_decode($carriera_string, true)["Esami"]["Esame"][0]["ANNO_IMM"];
        $fine_bonus = ($dataImmatricolazione + 4) . ("-05-01");
        if ($dataLaurea < $fine_bonus) {
            $this->bonus = true;
            $voto_min = 33;
            $indice_min = 0;
            $cfu_min = 3;

            for ($i = 0; $i < sizeof($this->esami); $i++) {
                $esame = $this->esami[$i];
                if ($esame->faMedia == 1 && $esame->votoEsame <= $voto_min && $esame->cfuEsame >= $cfu_min) {
                    $cfu_min = $esame->cfuEsame;
                    $voto_min = $esame->votoEsame;
                    $indice_min = $i;
                }
            }
            $this->esami[$indice_min]->faMedia = 0;
        } else {
            $this->bonus = false;
        }
        parent::calcolaMedia();
        $this->restituisciMediaEsamiInformatici();
    }

    public function restituisciMediaEsamiInformatici(): void
    {
        $esami = $this->esami;
        $somma_voto_cfu = 0;
        $somma_cfu_tot = 0;

        for ($i = 0; $i < sizeof($esami); $i++) {
            if ($esami[$i]->faMedia == 1 && $esami[$i]->informatico == 1) {
                $somma_voto_cfu += (int)$esami[$i]->votoEsame * (int)$esami[$i]->cfuEsame;
                $somma_cfu_tot += (int)$esami[$i]->cfuEsame;
            }
        }
        $this->mediaEsamiInformatici = round($somma_voto_cfu / $somma_cfu_tot, 3);
    }

}