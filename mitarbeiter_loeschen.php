<?php
/* Klasse Schicht_Mitarbeiter einbinden */
include('klassen/schicht_mitarbeiter.klasse.php');
$mid = $_GET['mid'];

/* ausgewählten Mitarbeiter löschen */
$mitarbeiter = new Mitarbeiter();
$mitarbeiter->loesche_mitarbeiter_durch_id($mid);

/* zum ausgewählten Mitarbeiter gehörende Schichtdaten löschen */
$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter->loesche_alle_schicht_mitarbeiter_durch_mid($mid);

/* Umleitung auf Mitarbeiter-Übersicht */
header('Location: '.$_SERVER['PHP_SELF'].'?seite=mitarbeiter');
?>