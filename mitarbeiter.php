<?php
if(isset($_GET['sub']))
{
	$activ = $_GET['sub'];
}
else
{
	$activ = 'uebersicht';
}
?>
<div id="submenu">
    <a href="index.php?seite=mitarbeiter&sub=uebersicht" <?php if($activ=='uebersicht') echo 'class="subactiv"'?>>&Uuml;bersicht</a> |
    <a href="index.php?seite=mitarbeiter&sub=details" <?php if($activ=='details') echo 'class="subactiv"'?>>Benutzer</a> |
<?php
    if($_SESSION['mitarbeiter']->role=='1')
    {
?>
     
    <a href="index.php?seite=mitarbeiter&sub=neu" <?php if($activ=='neu') echo 'class="subactiv"'?>>Neuen Benutzer Erstellen</a> |
<?php
    }
?>
    <a href="index.php?seite=mitarbeiter&sub=bearbeiten" <?php if($activ=='bearbeiten') echo 'class="subactiv"'?>>Benutzer Bearbeiten</a>

     |
    <a href="index.php?seite=mitarbeiter&sub=urlaub" <?php if($activ=='urlaub') echo 'class="subactiv"'?>>Urlaub</a>

</div>

<?php

$mitarbeiter = new Mitarbeiter();
$mitarbeiter_feld = array();

if(isset($_GET['action']) && $_GET['action']=='a')
{
    $mid = $_GET['mid'];

    $mitarbeiter = $mitarbeiter->hole_mitarbeiter_durch_id($mid);

    if($mitarbeiter->active>0)
    {
	$aktiv=0;
    }
    else
    {
	$aktiv=1;
    }

    $mitarbeiter->aktiviere_mitarbeiter_durch_id($mid, $aktiv);
}
if(isset($_GET['action']) && $_GET['action']=='l')
{
    /* Klasse Schicht_Mitarbeiter einbinden */
    include('klassen/schicht_mitarbeiter.klasse.php');
    $mid = $_GET['mid'];

    /* ausgew�hlten Mitarbeiter l�schen */
    $mitarbeiter->loesche_mitarbeiter_durch_id($mid);

    /* zum ausgew�hlten Mitarbeiter geh�rende Schichtdaten l�schen */
    $schicht_mitarbeiter = new Schicht_Mitarbeiter();
    $schicht_mitarbeiter->loesche_alle_schicht_mitarbeiter_durch_mid($mid);
}

if(isset($_GET['sub']))
{
	switch($_GET['sub'])
	{
            case 'uebersicht': include('mitarbeiter_uebersicht.php'); break;
            case 'details': include('mitarbeiter_details.php'); break;
            case 'neu': include('mitarbeiter_neu.php'); break;
            case 'bearbeiten': include('mitarbeiter_bearbeiten.php'); break;
            case 'urlaub': include('mitarbeiter_urlaub.php'); break;

	    default: break;
	}
}
else
{
	include('mitarbeiter_uebersicht.php');
}