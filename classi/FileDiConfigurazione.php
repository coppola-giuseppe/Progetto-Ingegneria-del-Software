<?php

class FileDiConfigurazione
{

    private static FileDiConfigurazione $config;

    private function __construct()
    {
    }


    public static function getConfig(): FileDiConfigurazione
    {
        if (!isset(self::$config)) {
            self::$config = new FileDiConfigurazione();
        }
        return self::$config;
    }

    public static function restituisciEsamiFiltrati(): array
    {
        return json_decode(
            file_get_contents(".//configurazione/filtro_esami.json", true),
            true
        );
    }

    public static function restituisciEsamiInformatici(): array
    {
        return json_decode(
            file_get_contents(".//configurazione/esami_informatici.json", true),
            true
        );
    }

    public static function restituisciFormulaVoto($cdl): string
    {
        $formula_string = file_get_contents(".//configurazione/info_cdl.json");
        $formula_json = json_decode($formula_string, true)[$cdl]["voto-laurea"];
        return json_encode($formula_json, JSON_UNESCAPED_SLASHES);
    }

    public static function restituisciCreditiCorso(string $cdl): string
    {
        $info = file_get_contents(".//configurazione/info_cdl.json");
        $cfu = json_decode($info, true)[$cdl]["tot-CFU"];
        return (string)$cfu;
    }

    public static function restituisciNomeCorso(string $cdl): string
    {
        $info = file_get_contents(".//configurazione/info_cdl.json");
        $corso = json_decode($info, true)[$cdl]["cdl"];
        return (string)$corso;
    }

    public static function restituisciParametri(string $cdl): array
    {
        $info = file_get_contents(".//configurazione/info_cdl.json");
        $par_t = json_decode($info, true)[$cdl]["par-T"];
        $par_c = json_decode($info, true)[$cdl]["par-C"];
        $parametri = array($par_t, $par_c);
        return $parametri;
    }

    public static function restituisciTestoEmail(string $cdl): string
    {
        $info = file_get_contents(".//configurazione/info_cdl.json");
        $text = json_decode($info, true)[$cdl]["txt-email"];
        return (string)$text;
    }

    public static function restituisciCorsiDiLaurea(): array
    {
        $info = file_get_contents(".//configurazione/info_cdl.json");
        $text = json_decode($info, true);
        return (array)$text;
    }

    public static function aggiornaEsamiInformatici(string $esami): void
    {
        file_put_contents(".//configurazione/esami_informatici.json", "[");
        file_put_contents(".//configurazione/esami_informatici.json", $esami, FILE_APPEND);
        file_put_contents(".//configurazione/esami_informatici.json", "]", FILE_APPEND);
    }

    public static function aggiornaFiltroEsami(string $cdl, string $matricola, array $esami_cdl, array $esami_avg): void
    {
        $jsonString = file_get_contents('.//configurazione/filtro_esami.json');
        $data = json_decode($jsonString, true);
        if (!isset($data["$cdl"]["$matricola"])) {
            $data["$cdl"]["$matricola"]["esami-non-avg"] = [];
            $data["$cdl"]["$matricola"]["esami-non-cdl"] = [];
        }

        for ($i = 0; $i < sizeof($esami_cdl); $i++) {
            $data[$cdl][$matricola]["esami-non-cdl"][] = $esami_cdl[$i];
        }

        for ($i = 0; $i < sizeof($esami_avg); $i++) {
            $data[$cdl][$matricola]["esami-non-avg"][] = $esami_avg[$i];
        }

        $newJsonString = json_encode($data);
        file_put_contents('.//configurazione/filtro_esami.json', $newJsonString);
    }

    public static function restituisciInfoCdl(string $cdl): array
    {
        $info = file_get_contents("../configurazione/info_cdl.json");
        $text = json_decode($info, true);
        return $text["$cdl"];
    }

    public static function aggiornaInfoCdl(string $cdl, string $info): void
    {
        $array = json_decode($info, true);

        $info_all = file_get_contents(".//configurazione/info_cdl.json");
        $text = json_decode($info_all, true);

        $text["$cdl"]["cdl"] = $array["cdl"];
        $text["$cdl"]["cdl-alt"] = $array["cdl-alt"];
        $text["$cdl"]["cdl-short"] = $array["cdl-short"];
        $text["$cdl"]["voto-laurea"] = $array["voto-laurea"];

        $text["$cdl"]["tot-CFU"] = (int)$array["tot-CFU"];

        $text["$cdl"]["par-T"]["min"] = (int)$array["par-T"]["min"];
        $text["$cdl"]["par-T"]["max"] = (int)$array["par-T"]["max"];
        $text["$cdl"]["par-T"]["step"] = (int)$array["par-T"]["step"];


        $text["$cdl"]["par-C"]["min"] = (int)$array["par-C"]["min"];
        $text["$cdl"]["par-C"]["max"] = (int)$array["par-C"]["max"];
        $text["$cdl"]["par-C"]["step"] = (int)$array["par-C"]["step"];

        $text["$cdl"]["txt-email"] = $array["txt-email"];


        $newJsonString = json_encode($text, JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
        file_put_contents('.//configurazione/info_cdl.json', $newJsonString);
    }


}