<?php

require_once("../classi/FileDiConfigurazione.php");
$config = FileDiConfigurazione::getConfig();
echo json_encode($config->restituisciInfoCdl($_POST["cdl"]));
?>