<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
<h2>Test automatizzati</h2>

<?php
require_once(realpath(dirname(__FILE__)) . '/classi/Test.php');
$test = new TestClass();

echo "<h3>Test classe CarrieraLaureando e CarrieraLaureandoInformatica</h3>";
$test->testCarriera();

echo "<h3>Test calcolo della media</h3>";
$test->testMedia();

echo "<h3>Test calcolo dei crediti</h3>";
$test->testCrediti();

echo "<h3>Test del calcolo del bonus</h3>";
$test->testBonus();

echo "<h3>Test della media degli esami informatici</h3>";
$test->testMediaInf();

echo "<h3>Test dell'uso della giusta formula per il calcolo del voto</h3>";
$test->testFormula();

echo "<h3>Test della generazione dei prospetti</h3>";
$test->testGenerazione();

echo "<h3>Confronto tra i prospetti destinati alla commissione generati e corretti</h3>";
echo "<h5> >per le matricole 123456 e 345678, scorrere il pdf generato poiché contiene entrambi i prospetti </h5>";

echo '<a href="prospetti/t-inf/t-inf-all.pdf" target="_blank">Visualizza prospetto generato di 123456</a> | <a
        href="prospetti_test/123456_output.pdf" target="_blank">Visualizza prospetto corretto di 123456</a>';
echo "<br>";


echo '<a href="prospetti/m-ele/m-ele-all.pdf" target="_blank">Visualizza prospetto generato di 234567</a> | <a
        href="prospetti_test/234567_output.pdf" target="_blank">Visualizza prospetto corretto di 234567</a>';
echo "<br>";


echo '<a href="prospetti/t-inf/t-inf-all.pdf" target="_blank">Visualizza prospetto generato di 345678</a> | <a
        href="prospetti_test/345678_output.pdf" target="_blank">Visualizza prospetto corretto di 345678</a>';
echo "<br>";

echo '<a href="prospetti/m-tel/m-tel-all.pdf" target="_blank">Visualizza prospetto generato di 456789</a> | <a
        href="prospetti_test/456789_output.pdf" target="_blank">Visualizza prospetto corretto di 456789</a>';
echo "<br>";

echo '<a href="prospetti/m-cyb/m-cyb-all.pdf" target="_blank">Visualizza prospetto generato di 567890</a> | <a
        href="prospetti_test/567890_output.pdf" target="_blank">Visualizza prospetto corretto di 567890</a>';
echo "<br>";


echo "<h3>Test dell'invio dei prospetti</h3>";
$test->testInvio();

?>

</body>
</html>