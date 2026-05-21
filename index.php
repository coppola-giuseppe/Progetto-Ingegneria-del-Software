<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laureandosi</title>
    <script>
        document.addEventListener("DOMContentLoaded", init);

        function init() {

            let btnApri = document.getElementById("btnApri");
            let btnInvia = document.getElementById("btnInvia");
            let btnConfig = document.getElementById("btnConfig");

            btnConfig.addEventListener("click", function e() {
                window.open('config.php');
            })

            btnApri.addEventListener("click", requestApri);

            function requestApri() {

                let url = window.location.search;
                let cdl_index = document.getElementById("corsi").options.selectedIndex;
                let cdl = document.getElementById("corsi").options[cdl_index].value;


                if (cdl === "null") {
                    if (url !== "") {
                        let corso = url.substring(7, 12);
                        let file = './prospetti/' + corso + '/' + corso + '-all.pdf';
                        window.open(file, '_new');
                    }
                } else {
                    let file = './prospetti/' + cdl + '/' + cdl + '-all.pdf';
                    window.open(file, '_new');
                }

            }

            btnInvia.addEventListener("click", requestInvia);

            async function requestInvia() {
                let info = new FormData;
                const searchParams = new URLSearchParams(window.location.search);
                let cdl = searchParams.get("corsi");
                let dataLaurea = searchParams.get("data");
                let matricole = searchParams.get("mat");
                let matricole_filter1 = matricole.replaceAll(/\s|\W|\s\W|\r\n|\n\r|\r|\n/g, ' ');
                let matricole_filter2 = matricole_filter1.replaceAll(/\s{2}/g, ' ');

                let arrayMatricole = matricole_filter2.split(' ');
                info.append('request', 'invia');
                info.append('corsi', cdl);
                info.append('data', dataLaurea);
                info.append("mat", "");
                let esito = 1;
                for (let i = 0; i < arrayMatricole.length; i++) {
                    info.set("mat", arrayMatricole[i]);
                    await fetch("./index.php", {
                        method: "POST",
                        body: info
                    })
                        .then(
                            (response) => response.text()
                        )
                        .then(data => {
                                esito = (data.slice(-1))
                            }
                        )
                    if (esito == 1) {
                        document.getElementById("esito").innerText = "Inviato prospetto " + (i + 1) + " di " + arrayMatricole.length;
                    } else {
                        document.getElementById("esito").innerText = "Errore nell'invio!";
                        break;
                    }
                }
                if (esito == 1) {
                    document.getElementById("esito").innerText = "Prospetti inviati con successo!";
                }
            }
        }


    </script>

    <style>
        #dati {

            padding: 5px;
            width: fit-content;
            justify-self: center;
            background-color: lightblue;
            border: royalblue solid 2px;
            display: grid;
            color: royalblue;
            font-size: large;
            font-weight: bold;
            grid-template-areas:    'title title title'
                            'cdl mat but'
                            'data mat but'
                            'config mat esito'
                            ' . . test';

            grid-template-columns: 300px 300px 150px;

        }

        input, select {
            border: royalblue solid 2px;
        }

        #title {
            grid-area: title;
            text-align: center;
            color: royalblue;
        }

        #cdl {
            grid-area: cdl;
        }

        #dataLaurea {
            grid-area: data;

        }

        #matricole {
            grid-area: mat;
        }

        #buttons {
            grid-area: but;
        }

        button, input, label, select, data {
            font-size: large;
        }

        #btnCrea, #btnInvia {
            border: black 1px solid;
            background-color: royalblue;
            box-shadow: 1px 1px 10px;
        }

        #btnCrea:hover, #btnInvia:hover {
            color: white;
            cursor: pointer;
        }

        #btnApri:hover {
            text-decoration: underline;
            cursor: pointer;

        }


        textarea {
            border: royalblue solid 2px;
            resize: none;
        }

        #esito {
            font-style: italic;
            color: crimson;
            grid-area: esito;
        }

        #btnApri {
            text-decoration: none;
            border: lightblue;
            background-color: lightblue;
            color: royalblue;
        }

        #test {
            grid-area: test;
            background-color: lightblue;
        }

        #test > a {
            visibility: hidden;
        }

        #test:hover > a {
            visibility: visible;
        }

        #config {
            grid-area: config;
        }

        #btnConfig:hover {
            background-color: white;
        }

    </style>
</head>
<body>
<div id="main">
    <h2 id="title">Gestione Prospetti di Laurea</h2>
    <div id="dati">
        <div id="cdl">
            <form id="form" method="get">
                <label for="corsi">CdL:</label>
                <br>
                <select name="corsi" id="corsi" style="font-style: italic; width: 200px;">

                    <option value="null" disabled selected>Seleziona un CdL</option>

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


        <div id="dataLaurea">

            <label for="data">Data Laurea: </label>
            <input type="date" name="data" id="data">


        </div>
        <div id="matricole">

            <label for="mat">Matricole:</label>
            <br><br>
            <textarea name="mat" id="mat" cols="30" rows="10"></textarea>

        </div>

        <div id="buttons">
            <br><br>
            <input type="submit" id="btnCrea" value="Crea Prospetti">
            <br><br>
            <button type="button" id="btnApri">Apri Prospetti</button>
            <br><br>
            <button type="button" id="btnInvia">Invia Prospetti</button>
        </div>

        <div id="esito">
            <?php
            require_once(realpath(dirname(__FILE__)) . '/classi/Interfaccia.php');
            if (isset($_GET["corsi"]) && isset($_GET["data"]) && isset($_GET["mat"])) {
                $matricole = preg_split("/\s|\W|\s\W|\r\n|\n\r|\r|\n/", $_GET["mat"]);

                //prendo l'indice degli elementi vuoti
                $index_empty = [];
                $k = 0;
                for ($i = 0; $i < sizeof($matricole); $i++) {
                    if ($matricole[$i] == "") {
                        $index_empty[$k] = $i;
                        $k++;
                    }
                }

                $matricole_filter = [];
                $k = 0;
                //creo un nuovo array ingorando gli indici in cui l'array precedente è vuoto
                for ($j = 0; $j < sizeof($matricole); $j++) {
                    if (!in_array($j, $index_empty)) {
                        $matricole_filter[$k] = $matricole[$j];
                        $k++;
                    }
                }
                $matricole = array_map("intval", $matricole_filter);

                try {
                    $Interfaccia = new Interfaccia($matricole, $_GET["corsi"], $_GET["data"]);
                    if (!$Interfaccia->creaProspetti()) {
                        throw  new Exception();
                    }
                    echo "Prospetti creati";
                } catch (Throwable $th) {
                    echo "Errore nella creazione dei prospetti";
                }
            }

            ?>
        </div>
        </form>
        <div id="test">
            <a href="test.php" target="_blank">Test</a>
        </div>
        <div id="config">
            <button type="button" id="btnConfig">Configurazione</button>
        </div>
    </div>
</div>
</body>
</html>

<?php
if (isset($_POST["request"]) && $_POST["request"] == "invia") {
    $matricole[0] = $_POST["mat"];
    $Interfaccia = new Interfaccia($matricole, $_POST["corsi"], $_POST["data"]);
    //fa echo dell'esito e verrà preso dalla fetch dell'index principale
    if ($Interfaccia->inviaProspetti()) {
        echo 1;
    } else {
        echo 0;
    }
}

?>
