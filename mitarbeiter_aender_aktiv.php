<?php
$mitarbeiter = new Mitarbeiter();

function aender_aktiv()
{
$mid = $_GET['mid'];

/* f�r ausgew�hlten Mitarbeiter wird status ge�ndert */
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

/* Umleitung auf Mitarbeiter-�bersicht 
header('Location: '.$_SERVER['PHP_SELF'].'?seite=mitarbeiter');*/
}
?>