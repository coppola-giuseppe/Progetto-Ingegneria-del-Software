<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configurazione</title>
    <style>
        #config {

            padding: 5px;
            justify-self: center;
            width: 60rem;
            background-color: lightblue;
            border: royalblue solid 2px;
            display: grid;
            color: royalblue;
            font-size: large;
            font-weight: bold;
            grid-template-areas:    "cdl . . file file "
                                    "separator separator separator separator separator"
                                    "informatica informatica informatica informatica esito "
                                    "filter filter filter filter esito"
                                    "info info info info esito";

            grid-template-columns: auto auto auto auto 250px;
            height: fit-content;
        }

        #title {
            text-align: center;
            color: royalblue;
        }

        #cdl {
            padding: 10px;
            font-size: x-large;
            grid-area: cdl;
            text-align: center;
        }

        #file {
            padding: 10px;
            font-size: x-large;
            grid-area: file;
            text-align: center;
        }

        select {
            font-size: large;
        }

        #separator {

            grid-area: separator;
            border: royalblue solid 1px;
        }

        #modeInformatica {
            padding-top: 10px;
            display: none;
            justify-self: center;
            grid-area: informatica;
        }

        #modeFilter {
            padding-top: 10px;
            padding-left: 20px;

            display: none;
            grid-area: filter;
            grid-template-columns: auto auto auto auto;
            grid-template-areas:    "labelFilter1 textFilter1 "
                                    ". . "
                                    "labelFilter2 textFilter2 "
                                    ". . "
                                    "labelFilter3 textFilter3 "
                                    ". ."
                                    " . btnFilter ";
            grid-template-rows: 30px 100px 100px 100px 100px 35px;
        }


        button {
            font-size: larger;
            width: fit-content;
            justify-self: center;
        }

        #modeInfo {
            display: none;
            grid-template-areas:    " label1 text1 . "
                                    " label2 text2 . "
                                    " label3 text3 . "
                                    " label4 text4 . "
                                    " label5 text5 . "
                                    " label6 text6 . "
                                    " label7 text7 . "
                                    " label8 text8 . "
                                    " label9 text9 . "
                                    " label10 text10 . "
                                    " label11 text11 . "
                                    " label12 text12 . "
                                    " btnCdl btnCdl esito ";
            grid-row-gap: 10px;
            grid-area: info;
            grid-template-columns: 120px 550px auto;
            grid-template-rows: repeat(11, auto) 320px auto;
            padding-top: 10px;
            padding-left: 20px;
        }

        #txt-email {
            white-space: pre-wrap;
        }

        #modeFilter > textarea {
            font-size: x-large;
        }


        #esito {
            align-content: end;
            padding-bottom: 30px;
            grid-area: esito;
        }

        #modeFilter > label {
            grid-area: labelFilter;
            font-size: xx-large;
        }

        #modeFilter > textarea {
            grid-area: textFilter;
        }

    </style>

    <script>
        document.addEventListener("DOMContentLoaded", init);

        function init() {

            let selectCorsi = document.getElementById("corsi");
            selectCorsi.addEventListener("click", checkSelect);

            let selectMode = document.getElementById("mode");
            selectMode.addEventListener("change", checkSelect);

            let btnSalvaEsami = document.getElementById("salvaEsami");
            btnSalvaEsami.addEventListener("click", salvaEsami);

            let btnSalvaFiltro = document.getElementById("salvaFiltro");
            btnSalvaFiltro.addEventListener("click", salvaFiltro);

            let btnSalvaCdL = document.getElementById("salvaCdL");
            btnSalvaCdL.addEventListener("click", salvaInfoCdl);

            async function salvaFiltro() {
                let matricola = document.getElementById("matricola").value;
                let esami_avg = document.getElementById("esami_avg").value.split(/\r?\n/);
                let esami_cdl = document.getElementById("esami_cdl").value.split(/\r?\n/);

                let esami_avg_json = [];
                for (let i = 0; i < esami_avg.length; i++) {
                    esami_avg_json[i] = '"' + esami_avg[i] + '"'
                }

                let esami_cdl_json = [];
                for (let j = 0; j < esami_cdl.length; j++) {
                    esami_cdl_json[j] = '"' + esami_cdl[j] + '"'
                }


                let cdl_index = document.getElementById("corsi").options.selectedIndex;
                let cdl = document.getElementById("corsi").options[cdl_index].value;
                let request = new FormData;
                request.append('richiesta', 'filtroEsami');
                request.append('cdl', cdl);
                request.append('matricola', matricola)
                request.append('esami_cdl', esami_cdl);
                request.append('esami_avg', esami_avg);
                let esito = 0;
                await fetch("config.php",
                    {
                        headers: {
                            'Accept': 'application/json'
                        },
                        method: "POST",
                        body: request
                    })
                    .then(
                        (response) => response.text()
                    )
                    .then(data => {
                            esito = data.slice(-1);
                        }
                    )

                let divEsito = document.getElementById("esito")
                if (esito == 1) {
                    divEsito.style.color = "green";
                    divEsito.innerText = "Filtro applicato con successo."
                } else {
                    divEsito.style.color = "red";
                    divEsito.innerText = "Errore durante l'applicazione del filtro."
                }
            }


            async function salvaEsami() {
                let esami = document.getElementById("lista_esami").value.split(/\r?\n/);
                esami.pop();

                let esami_json = [];

                for (let i = 0; i < esami.length; i++) {
                    esami_json[i] = '"' + esami[i] + '"'
                }

                let request = new FormData;
                request.append('richiesta', 'esamiInformatici');
                request.append('esami', esami_json);
                let esito = 0;
                await fetch("config.php",
                    {
                        headers: {
                            'Accept': 'application/json'
                        },
                        method: "POST",
                        body: request
                    })
                    .then(
                        (response) => response.text()
                    )
                    .then(data => {
                            esito = data.slice(-1);
                        }
                    )
                let divEsito = document.getElementById("esito")
                if (esito == 1) {
                    divEsito.style.color = "green";
                    divEsito.innerText = "Esami salvati con successo."
                } else {
                    divEsito.style.color = "red";
                    divEsito.innerText = "Errore durante il salvataggio."
                }
            }


            function checkSelect() {
                let divInf = document.getElementById("modeInformatica");
                let divFilter = document.getElementById("modeFilter");
                let divInfo = document.getElementById("modeInfo");
                let divEsito = document.getElementById("esito");

                divInf.style.display = "none";
                divFilter.style.display = "none";
                divInfo.style.display = "none";
                divEsito.textContent = "";

                let cdl_index = document.getElementById("corsi").options.selectedIndex;
                let cdl = document.getElementById("corsi").options[cdl_index].value;

                let mode_index = document.getElementById("mode").options.selectedIndex;
                let mode = document.getElementById("mode").options[mode_index].value;
                if (mode !== "null") {
                    switch (mode) {
                        case "inf":
                            if (cdl === "t-inf" && cdl !== "null")
                                divInf.style.display = "grid";
                            break;
                        case "filter":
                            if ((cdl !== "null"))
                                divFilter.style.display = "grid";
                            break;
                        case "info":
                            infoCdL();
                            divInfo.style.display = "grid";
                    }
                }
            }

            async function salvaInfoCdl() {

                let cdl_index = document.getElementById("corsi").options.selectedIndex;
                let cdl_name = document.getElementById("corsi").options[cdl_index].value;

                let cdl = document.getElementById("cdl-name").value;
                let cdl_alt = document.getElementById("cdl-alt").value;
                let cdl_short = document.getElementById("cdl-short").value;
                let voto_laurea = document.getElementById("voto-laurea").value;
                let tot_CFU = document.getElementById("tot-CFU").value;
                let t_min = document.getElementById("t-min").value;
                let t_max = document.getElementById("t-max").value;
                let t_step = document.getElementById("t-step").value;
                let c_min = document.getElementById("c-min").value;
                let c_max = document.getElementById("c-max").value;
                let c_step = document.getElementById("c-step").value;
                let txt_email = document.getElementById("txt-email").value;

                let array_info = {
                    "cdl": cdl,
                    "cdl-alt": cdl_alt,
                    "cdl-short": cdl_short,
                    "par-C": {"min": c_min, "max": c_max, "step": c_step},
                    "par-T": {"min": t_min, "max": t_max, "step": t_step},
                    "tot-CFU": tot_CFU,
                    "txt-email": txt_email,
                    "voto-laurea": voto_laurea
                }

                let request = new FormData;
                request.append('richiesta', 'infoCdl');
                request.append('info', JSON.stringify(array_info));
                if (cdl_name === "null")
                    request.append('cdl', cdl_short);
                else
                    request.append('cdl', cdl_name);
                let esito = 0;
                await fetch("config.php",
                    {
                        headers: {
                            'Accept': 'application/json'
                        },
                        method: "POST",
                        body: request
                    })
                    .then(
                        (response) => response.text()
                    )
                    .then(data => {
                            esito = data.slice(-1);
                        }
                    )

                let divEsito = document.getElementById("esito")
                if (esito == 1) {
                    divEsito.style.color = "green";
                    divEsito.innerText = "Corso di laurea aggiornato con successo."
                } else {
                    divEsito.style.color = "red";
                    divEsito.innerText = "Errore durante l'aggiornamento."
                }
            }

            async function infoCdL() {
                let cdl_index = document.getElementById("corsi").options.selectedIndex;
                let cdl = document.getElementById("corsi").options[cdl_index].value;
                if (cdl !== "null") {
                    let request = new FormData;
                    request.append('cdl', cdl);
                    let info_array = []
                    await fetch("request/request.php",
                        {
                            headers: {
                                'Accept': 'application/json'
                            },
                            method: "POST",
                            body: request
                        })
                        .then(
                            (response) => response.text()
                        )
                        .then(data => {
                                info_array = JSON.parse(data);
                            }
                        )

                    document.getElementById("cdl-name").innerText = info_array["cdl"];
                    document.getElementById("cdl-alt").innerText = info_array["cdl-alt"];
                    document.getElementById("cdl-short").innerText = info_array["cdl-short"];
                    document.getElementById("voto-laurea").innerText = info_array["voto-laurea"];
                    document.getElementById("tot-CFU").innerText = info_array["tot-CFU"];
                    document.getElementById("t-min").innerText = info_array["par-T"]["min"];
                    document.getElementById("t-max").innerText = info_array["par-T"]["max"];
                    document.getElementById("t-step").innerText = info_array["par-T"]["step"];
                    document.getElementById("c-min").innerText = info_array["par-C"]["min"];
                    document.getElementById("c-max").innerText = info_array["par-C"]["max"];
                    document.getElementById("c-step").innerText = info_array["par-C"]["step"];
                    document.getElementById("txt-email").textContent = info_array["txt-email"];
                } else {
                    document.getElementById("cdl-name").innerText = "";
                    document.getElementById("cdl-alt").innerText = "";
                    document.getElementById("cdl-short").innerText = "";
                    document.getElementById("voto-laurea").innerText = "";
                    document.getElementById("tot-CFU").innerText = "";
                    document.getElementById("t-min").innerText = "";
                    document.getElementById("t-max").innerText = "";
                    document.getElementById("t-step").innerText = "";
                    document.getElementById("c-min").innerText = "";
                    document.getElementById("c-max").innerText = "";
                    document.getElementById("c-step").innerText = "";
                    document.getElementById("txt-email").textContent = "";
                }
            }
        }

    </script>
</head>
<body>
<div id="main">
    <h2 id="title">Configurazione Laureandosi 2.0</h2>
    <div id="config">
        <div id="cdl">
            <label for="corsi">CdL:</label>
            <select name="corsi" id="corsi" style="font-style: italic; width: 200px;">

                <option value="null" selected>Seleziona un CdL</option>

                <?php
                require_once(realpath(dirname(__FILE__)) . '/classi/FileDiConfigurazione.php');

                $config = FileDiConfigurazione::getConfig();
                $array = $config->restituisciCorsiDiLaurea();
                foreach ($array as $cdl) {
                    echo "<option name='cdl' value='" . $cdl["cdl-short"] . "'>" . $cdl["cdl"] . "</option>";
                }
                ?>
            </select>

        </div>

        <div id="file">
            <label for="mode">Modalità:</label>
            <select name="mode" id="mode" style="font-style: italic; width: 300px;">
                <option value="null" disabled selected>Seleziona il campo da configurare</option>
                <option value="inf">Lista esami informatici</option>
                <option value="filter">Filtro Esami</option>
                <option value="info">Aggiungi/Modifica CdL</option>
            </select>
        </div>

        <div id="separator"></div>
        <br><br>
        <div id="modeInformatica">
            <label for="lista_esami">Esami informatici:</label>
            <br>
            <textarea name="lista_esami" id="lista_esami" cols="30" rows="20"><?php
                require_once(realpath(dirname(__FILE__)) . '/classi/FileDiConfigurazione.php');
                $config = FileDiConfigurazione::getConfig();
                $lista_esami = $config->restituisciEsamiInformatici();
                foreach ($lista_esami as $esame) {
                    echo $esame;
                    echo "\r\n";
                }
                ?></textarea>
            <br>
            <button id="salvaEsami">Salva</button>
        </div>

        <div id="modeFilter">
            <label for="matricola" style="grid-area: labelFilter1">Matricola: </label>
            <textarea name="matricola" id="matricola" cols="30" rows="2" style="grid-area: textFilter1"></textarea>

            <label for="esami_cdl" style="grid-area: labelFilter2">Esami non in CdL: </label>
            <textarea name="esami_cdl" id="esami_cdl" cols="30" rows="2" style="grid-area: textFilter2"></textarea>

            <label for="esami_avg" style="grid-area: labelFilter3">Esami non Avg: </label>
            <textarea name="esami_avg" id="esami_avg" cols="30" rows="2" style="grid-area: textFilter3"></textarea>

            <button id="salvaFiltro" style="grid-area: btnFilter">Salva</button>
        </div>

        <div id="modeInfo">

            <label for="cdl-name" style="grid-area: label1">Cdl:</label>
            <textarea name="cdl-name" id="cdl-name" cols="30" rows="1" style="grid-area: text1"></textarea>

            <label for="cdl-alt" style="grid-area: label2">Cdl-alt: </label>
            <textarea name="cdl-alt" id="cdl-alt" cols="30" rows="1" style="grid-area: text2"></textarea>

            <label for="cdl-short" style="grid-area: label3">Cdl-short: </label>
            <textarea name="cdl-short" id="cdl-short" cols="30" rows="1" style="grid-area: text3"></textarea>

            <label for="voto-laurea" style="grid-area: label4">Formula voto: </label>
            <textarea name="voto-laurea" id="voto-laurea" cols="30" rows="1" style="grid-area: text4"></textarea>

            <label for="tot-CFU" style="grid-area: label5">Cfu totali: </label>
            <textarea name="tot-CFU" id="tot-CFU" cols="30" rows="1" style="grid-area: text5"></textarea>

            <label for="t-min" style="grid-area: label6">T-min: </label>
            <textarea name="t-min" id="t-min" cols="30" rows="1" style="grid-area: text6"></textarea>

            <label for="t-max" style="grid-area: label7">T-max: </label>
            <textarea name="t-max" id="t-max" cols="30" rows="1" style="grid-area: text7"></textarea>

            <label for="t-step" style="grid-area: label8">T-step: </label>
            <textarea name="t-step" id="t-step" cols="30" rows="1" style="grid-area: text8"></textarea>

            <label for="c-min" style="grid-area: label9">C-min: </label>
            <textarea name="c-min" id="c-min" cols="30" rows="1" style="grid-area: text9"></textarea>

            <label for="c-max" style="grid-area: label10">C-max: </label>
            <textarea name="c-max" id="c-max" cols="30" rows="1" style="grid-area: text10"></textarea>

            <label for="c-step" style="grid-area: label11">C-step: </label>
            <textarea name="c-step" id="c-step" cols="30" rows="1" style="grid-area: text11"></textarea>

            <label for="txt-email" style="grid-area: label12">Testo email: </label>
            <textarea name="txt-email" id="txt-email" cols="30" rows="10" style="grid-area: text12"></textarea>

            <button id="salvaCdL" style="grid-area: btnCdl">Salva</button>
        </div>
        <div id="esito">
        </div>
    </div>
</div>
</body>
</html>
<?php
if (isset($_POST["richiesta"]) && $_POST["richiesta"] == "esamiInformatici") {
    echo 1;
    $config = FileDiConfigurazione::getConfig();
    $config->aggiornaEsamiInformatici($_POST["esami"]);
}
if (isset($_POST["richiesta"]) && $_POST["richiesta"] == "filtroEsami") {
    echo 1;
    $array_cdl = (explode(",", $_POST["esami_cdl"]));
    $array_avg = (explode(",", $_POST["esami_avg"]));
    $config = FileDiConfigurazione::getConfig();
    $config->aggiornaFiltroEsami($_POST["cdl"], $_POST["matricola"], $array_cdl, $array_avg);
}
if (isset($_POST["richiesta"]) && $_POST["richiesta"] == "infoCdl") {
    echo 1;
    $config = FileDiConfigurazione::getConfig();
    $config->aggiornaInfoCdl($_POST["cdl"], $_POST["info"]);
    $config->aggiornaFiltroEsami($_POST["cdl"], "*", [], []);
}
?>