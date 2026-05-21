<?php

class CarrieraLaureando
{
    public int $matricola;
    public string $nome;
    public string $corsoDiStudio;
    public string $cognome;
    public string $email;
    public float $media;
    public string $formulaVoto;
    public array $esami;

    public string $dataLaurea;
    private FileDiConfigurazione $config;


    public function __construct(int $matricola, string $cdl, string $data)
    {
        require_once(realpath(dirname(__FILE__)) . "/EsameLaureando.php");
        require_once(realpath(dirname(__FILE__)) . "/FileDiConfigurazione.php");
        require_once(realpath(dirname(__FILE__)) . "/GestioneCarrieraStudente.php");

        $this->matricola = $matricola;
        $this->corsoDiStudio = $cdl;

        $this->dataLaurea = $data;

        $anagrafica_string = GestioneCarrieraStudente::restituisciAnagraficaStudente($matricola);
        if ($anagrafica_string == "error") {
            throw new Exception();
        }

        $anagrafica = json_decode($anagrafica_string, true)["Entries"]["Entry"];


        $this->nome = $anagrafica["nome"];
        $this->cognome = $anagrafica["cognome"];
        $this->email = $anagrafica["email_ate"];

        $this->config = FileDiConfigurazione::getConfig();

        //controllo gli esami da filtrare per il corso di studi e per la matricola data
        $config = FileDiConfigurazione::restituisciEsamiFiltrati()[$cdl];
        $filtro_esami = array_values(
            array_filter(
                $config,
                function ($mat) use ($matricola) {
                    return $mat == "*" || $mat == $matricola;
                },
                ARRAY_FILTER_USE_KEY
            )
        );

        if (count($filtro_esami) == 2) {
            //c'è qualche filtro particolare per la matricola
            //creo un unico array unendo i valori di esami-non-avg e  di esami-non-cdl
            $filtro_esami = array_merge_recursive($filtro_esami[0], $filtro_esami[1]);
        } else {
            $filtro_esami = $filtro_esami[0];
        }


        $carriera_string = GestioneCarrieraStudente::restituisciCarrieraStudente($matricola);
        $carriera = json_decode($carriera_string, true)["Esami"]["Esame"];
        $this->esami = array();

        $n_ciclo = count($carriera) - (($this->corsoDiStudio == "t-inf") ? 1 : 0);

        for ($i = 0; $i < $n_ciclo; $i++) {
            $esame = $carriera[$i];


            $esame_nome = json_encode($esame["DES"]);
            $esame_voto = strcmp($esame["VOTO"], '30  e lode') == 0 ? 33 : (int)$esame["VOTO"];
            $esame_cfu = json_encode($esame["PESO"]);
            $esame_cod = json_encode($esame["COD"]);
            $esame_curr = !in_array($esame["DES"], $filtro_esami["esami-non-cdl"]);
            $esame_avg = ('"' . $esame_curr . '"' && !in_array($esame["DES"], $filtro_esami["esami-non-avg"]));
            $inf_array = FileDiConfigurazione::restituisciEsamiInformatici();
            $esame_inf = in_array($esame["DES"], $inf_array, true);

            $this->esami[$i] = new EsameLaureando(
                $esame_nome, $esame_cod, $esame_cfu, $esame_voto, $esame_curr, $esame_avg, $esame_inf
            );
        }
        $this->calcolaMedia();

        $this->formulaVoto = FileDiConfigurazione::restituisciFormulaVoto($cdl);
    }

    public function calcolaMedia(): void
    {
        $esami = $this->esami;
        $somma_voto_cfu = 0;
        $somma_cfu_tot = 0;

        for ($i = 0; $i < sizeof($esami); $i++) {
            if ($esami[$i]->faMedia == 1 && $esami[$i]->curricolare == 1) {
                $somma_voto_cfu += (int)$esami[$i]->votoEsame * (int)$esami[$i]->cfuEsame;
                $somma_cfu_tot += (int)$esami[$i]->cfuEsame;
            }
        }
        $this->media = round($somma_voto_cfu / $somma_cfu_tot, 4);
    }

    public function restituisciCFUmedia(): string
    {
        $esami = $this->esami;
        $cfu = 0;
        for ($i = 0; $i < sizeof($esami); $i++) {
            if ($esami[$i]->faMedia == 1 && $esami[$i]->curricolare == 1) {
                $cfu += (int)$esami[$i]->cfuEsame;
            }
        }
        return (string)$cfu;
    }

    public function restituisciCFU(): int
    {
        $esami = $this->esami;
        $cfu = 0;
        for ($i = 0; $i < sizeof($esami); $i++) {
            if ($esami[$i]->curricolare == 1) {
                $cfu += (int)$esami[$i]->cfuEsame;
            }
        }
        return (string)$cfu;
    }

}