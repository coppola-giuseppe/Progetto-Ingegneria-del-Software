<?php

class GestioneCarrieraStudente
{
    public static function restituisciCarrieraStudente(int $matricola): string
    {
        $string = file_get_contents(
            ".//dati/carriera/" . $matricola . "_esami.json"
        );
        $json = json_decode($string, true);


        return json_encode($json);
    }


    public static function restituisciAnagraficaStudente(int $matricola): string
    {
        //evita di mostrare il warning all'interfaccia in caso di inserimento di matricola non presente
        error_reporting(E_ERROR | E_PARSE);

        $string = file_get_contents(
            ".//dati/anagrafica/" . $matricola . "_anagrafica.json"
        );
        $json = json_decode($string, true);
        return json_encode($json);
    }

}

?>