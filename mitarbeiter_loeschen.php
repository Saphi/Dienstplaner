<?php
/* Klasse Schicht_Mitarbeiter einbinden */
include('klassen/schicht_mitarbeiter.klasse.php');
$mid = $_GET['mid'];

/* ausgew�hlten Mitarbeiter l�schen */
$mitarbeiter = new Mitarbeiter();
$mitarbeiter->loesche_mitarbeiter_durch_id($mid);

/* zum ausgew�hlten Mitarbeiter geh�rende Schichtdaten l�schen */
$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter->loesche_alle_schicht_mitarbeiter_durch_mid($mid);

/* Umleitung auf Mitarbeiter-�bersicht */
header('Location: '.$_SERVER['PHP_SELF'].'?seite=mitarbeiter');
?>