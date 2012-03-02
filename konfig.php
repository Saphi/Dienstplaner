<script>
    function Changecolor (farbe){
       document.getElementById("farbeanz").style.backgroundColor = "#"+farbe;
       document.getElementById("farbewert").value = farbe;
    }
</script>
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
    <a href="index.php?seite=konfig&sub=uebersicht" <?php if($activ=='uebersicht') echo 'class="subactiv"'?>>Schichten &Uuml;bersicht</a> |
         
    <a href="index.php?seite=konfig&sub=neu" <?php if($activ=='neu') echo 'class="subactiv"'?>>Neue Schicht Erstellen</a> |

    <a href="index.php?seite=konfig&sub=bearbeiten" <?php if($activ=='bearbeiten') echo 'class="subactiv"'?>>Schicht Bearbeiten</a> |
    <a href="index.php?seite=konfig&sub=arbeitstage" <?php if($activ=='arbeitstage') echo 'class="subactiv"'?>>Arbeitstage</a> |
    <a href="index.php?seite=konfig&sub=belegung" <?php if($activ=='belegung') echo 'class="subactiv"'?>>Schicht Belegung</a> 

</div>

<?php
/* Klasse Schicht einbinden */
include('klassen/schicht.klasse.php');

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
            case 'uebersicht': include('schicht_uebersicht.php'); break;
            case 'neu': include('schicht_neu.php'); break;
            case 'bearbeiten': include('schicht_bearbeiten.php'); break;
            case 'arbeitstage': include('arbeitstage.php'); break;
            case 'belegung': include('schicht_belegung.php'); break;

	    default: break;
	}
}
else
{
	include('schicht_uebersicht.php');
}
?>
