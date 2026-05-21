<?php

class TestClass
{
    public function __construct()
    {
    }

    public function testCarriera(): void
    {
        require_once(realpath(dirname(__FILE__)) . '/CarrieraLaureandoInformatica.php');

//--------------   test 123456 -----------------------
        $cl = new CarrieraLaureandoInformatica("123456", "t-inf", "2023-01-04");

        $expected = 123456;
        $result = $cl->matricola;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "GIANLUIGI";
        $result = $cl->nome;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "DONNARUMMA";
        $result = $cl->cognome;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "nome.cognome@studenti.unipi.it";
        $result = $cl->email;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = '"ELETTROTECNICA"';

        $result = $cl->esami[0]->nomeEsame;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 26;
        $result = $cl->esami[0]->votoEsame;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 1;
        $result = $cl->esami[0]->faMedia;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = false;
        $result = $cl->bonus;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 23.667;
        $result = $cl->mediaEsamiInformatici;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        echo "test laureando in ingegneria informatica, senza diritto di bonus, eseguiti";
        echo "<br>";

//--------------   test 345678 -----------------------

        $cl = new CarrieraLaureandoInformatica("345678", "t-inf", "2023-01-04");

        $expected = 345678;
        $result = $cl->matricola;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "NICCOLO";
        $result = $cl->nome;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "BARELLA";
        $result = $cl->cognome;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "nome.cognome@studenti.unipi.it";
        $result = $cl->email;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = '"INGEGNERIA DEL SOFTWARE"';

        $result = $cl->esami[0]->nomeEsame;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 30;
        $result = $cl->esami[0]->votoEsame;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 1;
        $result = $cl->esami[0]->faMedia;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = true;
        $result = $cl->bonus;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 25.75;
        $result = $cl->mediaEsamiInformatici;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        echo "test laureando in ingegneria informatica, con diritto di bonus, eseguiti";
        echo "<br>";

//--------------   234567 -----------------------


        $cl = new CarrieraLaureando("234567", "m-ele", "2023-01-04");

        $expected = 234567;
        $result = $cl->matricola;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "ALESSANDRO";
        $result = $cl->nome;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "BASTONI";
        $result = $cl->cognome;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = "nome.cognome@studenti.unipi.it";
        $result = $cl->email;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = '"NANOELETTRONICA E FOTONICA"';
        $result = $cl->esami[0]->nomeEsame;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 20;
        $result = $cl->esami[0]->votoEsame;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }

        $expected = 1;
        $result = $cl->esami[0]->faMedia;
        if ($expected != $result) {
            echo "CarrieraLaureando : errore: expected:" . $expected . " received:" . $result;
        }
        echo "test laureando nella magistrale di ingegneria elettronica eseguiti";
        echo "<br>";
    }

    public function testMedia(): void
    {
        $c1 = new CarrieraLaureandoInformatica("123456", "t-inf", "2023-01-04");
        $c2 = new CarrieraLaureando("234567", "m-ele", "2023-01-04");
        $c3 = new CarrieraLaureandoInformatica("345678", "t-inf", "2023-01-04");
        $c4 = new CarrieraLaureando("456789", "m-tel", "2023-01-04");
        $c5 = new CarrieraLaureando("567890", "m-cyb", "2023-01-04");

//test se la media è valida
        if ($c1->media < 18 || $c1->media > 33 || $c2->media < 18 || $c2->media > 33 || $c3->media < 18 || $c3->media > 33 || $c4->media < 18 || $c4->media > 33 || $c5->media < 18 || $c5->media > 33) {
            echo "CarrieraLaureando: errore nel calcolo delle medie : non sono nel range [18-33]";
        }

        echo "test della validità della media eseguiti";
        echo "<br>";

// test esatti dei casi di test
        if ($c1->media < 23 || $c1->media > 24) {
            echo "Carriera Laureando : media1 errata:" . $c1->media;
        }
        if ($c2->media < 24 || $c2->media > 25) {
            echo "Carriera Laureando : media2 errata:" . $c2->media;
        }
        if ($c3->media < 25 || $c3->media > 26) {
            echo "Carriera Laureando : media3 errata:" . $c3->media;
        }
        if ($c4->media < 32 || $c4->media > 33) {
            echo "Carriera Laureando : media4 errata:" . $c4->media;
        }
        if ($c5->media < 24 || $c5->media > 25) {
            echo "Carriera Laureando : media5 errata:" . $c5->media;
        }
        echo "test dell'esattezza della media dei casi di test eseguiti";
        echo "<br>";
    }

    public function testCrediti(): void
    {
        $c1 = new CarrieraLaureandoInformatica("123456", "t-inf", "2023-01-04");
        $c2 = new CarrieraLaureando("234567", "m-ele", "2023-01-04");
        $c3 = new CarrieraLaureandoInformatica("345678", "t-inf", "2023-01-04");
        $c4 = new CarrieraLaureando("456789", "m-tel", "2023-01-04");
        $c5 = new CarrieraLaureando("567890", "m-cyb", "2023-01-04");


        if ($c1->restituisciCFUmedia() != 174) {
            echo "Carriera Laureando1 : crediti che fanno media errati: ricevuto" . $c1->creditiCheFannoMedia();
        }
        if ($c2->restituisciCFUmedia() != 102) {
            echo "Carriera Laureando2 : crediti che fanno media errati: ricevuto" . $c2->restituisciCFUmedia();
        }
        if ($c3->restituisciCFUmedia() != 165) {
            echo "Carriera Laureando3 : crediti che fanno media errati: ricevuto" . $c3->restituisciCFUmedia();
        } //bonus incluso
        if ($c4->restituisciCFUmedia() != 96) {
            echo "Carriera Laureando4 : crediti che fanno media errati: ricevuto" . $c4->restituisciCFUmedia();
        }
        if ($c5->restituisciCFUmedia() != 102) {
            echo "Carriera Laureando5 : crediti che fanno media errati: ricevuto" . $c5->restituisciCFUmedia();
        }


        echo "test dell'esattezza dei crediti che fanno media eseguiti";
        echo "<br>";

        if ($c1->restituisciCFU() != 177) {
            echo "Carriera Laureando1 : crediti errati: ricevuto" . $c1->restituisciCFU();
        }
        if ($c2->restituisciCFU() != 102) {
            echo "Carriera Laureando2 : crediti errati: ricevuto" . $c2->restituisciCFU();
        }
        if ($c3->restituisciCFU() != 177) {
            echo "Carriera Laureando3 : crediti errati: ricevuto" . $c3->restituisciCFU();
        }
        if ($c4->restituisciCFU() != 96) {
            echo "Carriera Laureando4 : crediti errati: ricevuto" . $c4->restituisciCFU();
        }
        if ($c5->restituisciCFU() != 120) {
            echo "Carriera Laureando5 : crediti errati: ricevuto" . $c5->restituisciCFU();
        }

        echo "test del calcolo dei crediti totali eseguiti";
        echo "<br>";
    }

    public function testBonus(): void
    {
        $c1 = new CarrieraLaureandoInformatica("123456", "t-inf", "2025-05-05");
        $c2 = new CarrieraLaureandoInformatica("345678", "t-inf", "2025-05-05");
        $c3 = new CarrieraLaureandoInformatica("123456", "t-inf", "2017-05-05");
        $c4 = new CarrieraLaureandoInformatica("345678", "t-inf", "2020-05-05");


        $expected = "NO";
        $result = ($c1->bonus) ? "SI" : "NO";
        if ($expected != $result) {
            echo "CarrieraLaureandoInformatica : errore1: expected:" . $expected . " received:" . $result;
        }
        $expected = "NO";
        $result = ($c2->bonus) ? "SI" : "NO";
        if ($expected != $result) {
            echo "CarrieraLaureandoInformatica : errore2: expected:" . $expected . " received:" . $result;
        }
        $expected = "SI";
        $result = ($c3->bonus) ? "SI" : "NO";
        if ($expected != $result) {
            echo "CarrieraLaureandoInformatica : errore1: expected:" . $expected . " received:" . $result;
        }
        $expected = "SI";
        $result = ($c4->bonus) ? "SI" : "NO";
        if ($expected != $result) {
            echo "CarrieraLaureandoInformatica : errore2: expected:" . $expected . " received:" . $result;
        }

        echo "test della verifica dell'applicazione del bonus eseguiti";
        echo "<br>";

//verifico che i cfu che fanno media cambino con l'assegnazione del bonus
        if ($c1->restituisciCFUmedia() == $c3->restituisciCFUmedia()) {
            echo "CarrieraLaureandoInformatica : errore laureando 1 nel bonus, la media non è cambiata";
        }
        if ($c2->restituisciCFUmedia() == $c4->restituisciCFUmedia()) {
            echo "CarrieraLaureandoInformatica : errore laureando 2 nel bonus, la media non è cambiata";
        }

//verifico che la media calcolata col bonus sia corretta

        if ($c4->media < 25.5 || $c4->media > 25.6) {
            echo "CarrieraLaureandoInformatica : errore laureando 2 nel bonus, la media non è corretta: received " . $c4->media;
        }

        echo "test della verifica della media aggiornata eseguiti";
        echo "<br>";
    }

    public function testMediaInf(): void
    {
        $c1 = new CarrieraLaureandoInformatica("123456", "t-inf", "2025-05-05");
        $c2 = new CarrieraLaureandoInformatica("345678", "t-inf", "2020-05-05");

// controllo che sia corretta
        if ($c1->mediaEsamiInformatici < 23.6 || $c1->mediaEsamiInformatici > 23.7) {
            echo "CarrieraLaureandoInformatica : errore laureando 1 nella media informatica: received " . $c1->getMediaEsamiInformatici(
                );
            echo "<br>";
        }
        if ($c2->mediaEsamiInformatici < 25.7 || $c2->mediaEsamiInformatici > 25.8) {
            echo "CarrieraLaureandoInformatica : errore laureando 2 nella media informatica: received " . $c2->getMediaEsamiInformatici(
                );
            echo "<br>";
        }
        echo "test della verifica della media degli esami informatici eseguiti";
        echo "<br>";
    }

    public function testFormula(): void
    {
        $c1 = new CarrieraLaureandoInformatica("123456", "t-inf", "2023-01-04");
        $c2 = new CarrieraLaureando("234567", "m-ele", "2023-01-04");
        $c3 = new CarrieraLaureandoInformatica("345678", "t-inf", "2023-01-04");
        $c4 = new CarrieraLaureando("456789", "m-tel", "2023-01-04");
        $c5 = new CarrieraLaureando("567890", "m-cyb", "2023-01-04");

        if ($c1->formulaVoto != '"M*3+18+T+C"') {
            echo "CarrieraLaureandoInformatica : errore formula del laureando 1: received " . $c1->formulaVoto;
            echo "<br>";
        }
        if ($c2->formulaVoto != '"4*(M*CFU+T*18)/(CFU+18)"') {
            echo "CarrieraLaureando : errore formula del laureando 2: received " . $c2->formulaVoto;
            echo "<br>";
        }
        if ($c3->formulaVoto != '"M*3+18+T+C"') {
            echo "CarrieraLaureandoInformatica : errore formula del laureando 2: received " . $c3->formulaVoto;
            echo "<br>";
        }
        if ($c4->formulaVoto != '"M*11/3+C"') {
            echo "CarrieraLaureando : errore formula del laureando 2: received " . $c4->formulaVoto;
            echo "<br>";
        }
        if ($c5->formulaVoto != '"M*110/30+C"') {
            echo "CarrieraLaureando : errore formula del laureando 2: received " . $c5->formulaVoto;
            echo "<br>";
        }

        echo "test dell'uso delle formule eseguiti";
        echo "<br>";
    }

    public function testGenerazione(): void
    {
        require_once(realpath(dirname(__FILE__)) . '/GeneratoreProspetti.php');
        require_once(realpath(dirname(__FILE__)) . '/Interfaccia.php');


//generazione prospetto per 123456
        try {
            $matricola = ["123456"];
            $prospetto1 = new Interfaccia($matricola, "t-inf", "2023-01-04");
            $prospetto1->creaProspetti();
            echo "Generato prospetto di 123456";
        } catch (Throwable $th) {
            echo "Errore nella generazione del prospetto di 123456";
        }

        echo "<br>";

//generazione prospetto per 234567
        try {
            $matricola = ["234567"];
            $prospetto2 = new Interfaccia($matricola, "m-ele", "2023-01-04");
            $prospetto2->creaProspetti();
            echo "Generato prospetto di 234567";
        } catch (Throwable $th) {
            echo "Errore nella generazione del prospetto di 234567";
        }
        echo "<br>";

//generazione prospetto per 345678
        try {
            $matricola = ["345678"];

            $prospetto3 = new Interfaccia($matricola, "t-inf", "2023-01-04");
            $prospetto3->creaProspetti();
            echo "Generato prospetto di 345678";
        } catch (Throwable $th) {
            echo "Errore nella generazione del prospetto di 345678";
        }
        echo "<br>";

//generazione prospetto per 456789
        try {
            $matricola = ["456789"];

            $prospetto4 = new Interfaccia($matricola, "m-tel", "2023-01-04");
            $prospetto4->creaProspetti();
            echo "Generato prospetto di 456789";
        } catch (Throwable $th) {
            echo "Errore nella generazione del prospetto di 456789";
        }
        echo "<br>";

//generazione prospetto per 567890
        try {
            $matricola = ["567890"];
            $prospetto5 = new Interfaccia($matricola, "m-cyb", "2023-01-04");
            $prospetto5->creaProspetti();
            echo "Generato prospetto di 567890";
        } catch (Throwable $th) {
            echo "Errore nella generazione del prospetto di 567890";
        }

        echo "<br>";


//creo un pdf unico destinato alla commissione con i due laureandi in ingegneria informatica per mostrarli al test successivo
        $matricola = ["123456", "345678"];
        $prospetto5 = new Interfaccia($matricola, "t-inf", "2023-01-04");
        $prospetto5->creaProspetti();
    }

    public function testInvio(): void
    {
        require_once(realpath(dirname(__FILE__)) . '/GestoreInvioEmail.php');

        $c1 = new CarrieraLaureandoInformatica("123456", "t-inf", "2023-01-04");
        $c2 = new CarrieraLaureando("234567", "m-ele", "2023-01-04");
        $c3 = new CarrieraLaureandoInformatica("345678", "t-inf", "2023-01-04");
        $c4 = new CarrieraLaureando("456789", "m-tel", "2023-01-04");
        $c5 = new CarrieraLaureando("567890", "m-cyb", "2023-01-04");


        $GestoreInvioEmail = new GestoreInvioEmail();

//email a cui inviare i casi di test, in questo caso è la mia
        $email_di_test = "g.coppola12@studenti.unipi.it";

//test invio 123456
        try {
            $GestoreInvioEmail->inviaEmailLaureandi(array($c1), "t-inf", $email_di_test);
            echo "Inviata email a 123456 con successo";
        } catch (Throwable $th) {
            echo "Errore nell'invio dell'email di 123456";
        }

        echo "<br>";

//test invio 234567
        try {
            $GestoreInvioEmail->inviaEmailLaureandi(array($c2), "m-ele", $email_di_test);
            echo "Inviata email a 234567 con successo";
        } catch (Throwable $th) {
            echo "Errore nell'invio dell'email di 234567";
        }

        echo "<br>";

//test invio 345678
        try {
            $GestoreInvioEmail->inviaEmailLaureandi(array($c3), "t-inf", $email_di_test);
            echo "Inviata email a 345678 con successo";
        } catch (Throwable $th) {
            echo "Errore nell'invio dell'email di 345678";
        }

        echo "<br>";

//test invio 456789
        try {
            $GestoreInvioEmail->inviaEmailLaureandi(array($c4), "m-tel", $email_di_test);
            echo "Inviata email a 456789 con successo";
        } catch (Throwable $th) {
            echo "Errore nell'invio dell'email di 456789";
        }

        echo "<br>";

//test invio 567890
        try {
            $GestoreInvioEmail->inviaEmailLaureandi(array($c5), "m-cyb", $email_di_test);
            echo "Inviata email a 567890 con successo";
        } catch (Throwable $th) {
            echo "Errore nell'invio dell'email di 567890";
        }
        echo "<br>";
    }

}

?>
