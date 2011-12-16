<?php
/* Klasse Schicht einbinden */
include('klassen/schicht.klasse.php');

$sid = $_GET['sid'];

/* ausgew�hlte Schicht l�schen */
$schicht = new Schicht();
$schicht->loesche_schicht_durch_id($sid);

$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter->loesche_alle_schicht_mitarbeiter_durch_sid($sid);

mysql_query("DELETE FROM schicht_ma WHERE SID='".$sid."'");

/* Umleitung auf Schichten-�bersicht */
header('Location: '.$_SERVER['PHP_SELF'].'?seite=konfig');
?>