<?php



/* Mitarbeiterklasse includieren, weil sie in der Session die danach gestartet wird ben�tigt wird.
 * Testen ob Mitarbeiterobjekt gesetzt wurde, d.h. Recht hat die Seiten einzusehen, ansonsten auf anmelden.php weiterleiten.
 */
include('inc/config.php');
include('klassen/mitarbeiter.klasse.php');
session_start();
if($_SESSION['mitarbeiter'])
{




?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Dienstplaner</title>
		<link rel="stylesheet" type="text/css" href="css/main_css.css">
          <link rel="stylesheet" type="text/css" href="css/kalender.css">
          <script type="text/javascript" src="js/kalender.js"></script>
	</head>
	<body>

		<div id="seite">
			<div id="kopf">
                             
				<div id="angemeldet">
<?php
					/* Variable $recht auf 1 setzen ,wenn Mitarbeiter Administratorrechte hat, ansonsten auf 0 setzen.
					 */
					if($_SESSION['mitarbeiter']->role=='1')
					{
						$recht = 'Admin';
					}
					else
					{
						$recht = 'Mitarbeiter';
					}
            		echo $_SESSION['mitarbeiter']->first_name.' '.$_SESSION['mitarbeiter']->last_name.' ('.$recht.') &nbsp;&nbsp;|&nbsp;&nbsp; ';
            		echo '<a href="abmelden.php">abmelden</a>';

if(isset($_GET['seite']))
{
	$mainactiv = $_GET['seite'];
}
else
{
	$mainactiv = 'mitarbeiter';
}
?>
            	</div>
            	<a href="index.php" id="logo"></a>
 <?php include('inc/hilfe.php');?>
	            <div id="menu">
		        	<a href="index.php?seite=mitarbeiter" id="menu_mitarbeiter" class="menu_objekt <?php if($mainactiv=='mitarbeiter') echo 'mitarbeiter_active'; ?>"><div class="menu_text" id="menu_text_mitarbeiter"> </div></a>



		            <a href="index.php?seite=kalender" id="menu_kalender" class="menu_objekt <?php if($mainactiv=='kalender') echo 'kalender_active'; ?>"><div class="menu_text" id="menu_text_kalender"> </div></a>

	           	 	<a href="index.php?seite=dienstplan" id="menu_dienstplan" class="menu_objekt <?php if($mainactiv=='dienstplan') echo 'dienstplan_active'; ?>"><div class="menu_text" id="menu_text_dienstplan"> </div></a>
<?php
/* Nur anzeigen, wenn Mitarbeiter Administratorrechte hat
 */
if($_SESSION['mitarbeiter']->role=='1')
{
?>
    <a href="index.php?seite=konfig" id="menu_schicht" class="menu_objekt <?php if($mainactiv=='konfig') echo 'konfig_active'; ?>"><div class="menu_text" id="menu_text_schicht"> </div></a>
<?php
}
?>
</div>

                </div>
        	<div id="hauptbereich">
	           	 <div id="inhalt">

<?php
/* Datenbankverbindung herstellen
 */



/* Wenn Seite in URL �bergeben wurde includieren, ansonsten mitarbeiter.php includieren
 */
if(isset($_GET['seite']))
{
	switch($_GET['seite'])
	{
            case 'mitarbeiter': include('mitarbeiter.php'); break;
	    case 'konfig': include('konfig.php'); break;
	    case 'kalender': include('kalender.php'); break;
            case 'schicht_mitarbeiter': include('schicht_mitarbeiter.php'); break;
	    case 'dienstplan': include('dienstplan.php'); break;
	    default: break;
	}
}
else
{
	include('mitarbeiter.php');
}

include('inc/footer.php');


}
else
{
	header('Location: anmelden.php');
}

?>