<?php
/* Session holen/starten.
 * Datenbankverbindung herstellen.
 * Mitarbeiterklasse includieren.
 */
session_start();
include('inc/config.php');
include('klassen/mitarbeiter.klasse.php');

/* Wenn Formular abgeschickt wird und der Mitarbeiter sich anmelden will.
 * Mitarbeiter anhand der eingegebenen E-Mail Adresse holen und md5 verschlüsseltes Passwort und Aktivstatus auswerten.
 * Wenn beides erfolgreich Mitarbeiter Objekt in Session speichern für spütere Rechte und Aktiv abfragen.
 */
if(isset($_POST['anmelden']))
{
	$mitarbeiter = new Mitarbeiter();
	$mitarbeiter = $mitarbeiter->hole_mitarbeiter_durch_email($_POST['email']);

	if($mitarbeiter && $mitarbeiter->pw==md5($_POST['pw']))
	{
		if($mitarbeiter->aktiv=='1')
		{
			$_SESSION['mitarbeiter'] = $mitarbeiter;
			header('Location: index.php');
		}
		else
		{
			$fehler = 'Sie müssen erst vom Administrator aktiviert werden um sich einloggen zu können!';
		}
	}
	else
	{
		$fehler = 'Ihr Mitarbeitername oder Passwort ist falsch oder nicht vorhanden!';
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Dienstplaner</title>
		<link rel="stylesheet" type="text/css" href="css/main_css.css">
	</head>
	<body>

            
          
        <div id="seite_login">
        	<div id="kopf_login" >
            	<a href="index.php" id="logo"></a>
            </div>
            <div id="hauptbereich_login">
                <div id="content_login">
            	<form action="anmelden.php" method="post" id="zentriert">
            		<table>
            			<tr>
            				<td colspan="2"><h1>Anmeldung</h1></td>
            			</tr>
<?php
/* Fehlerausgabe, wenn Fehler vorhanden.
 */
if(isset($fehler))
{
	echo '<tr><td colspan="2" class="fehler">'.$fehler.'</td></tr>';
}
?>
            			<tr>
            				<td colspan="2"><input class="feld" type="Text" size="43" name="email" value="Benutzername (EMail)" onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"></td>
                                </tr>
                                <tr>

                                        <td colspan="2"><input class="feld" type="Password" size="43" name="pw" value="Passwort" onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"></td>
                                </tr>
                                
                                <tr>
                                        <td><input class="knopf_anmelden" type="submit" name="anmelden" value=" "></td>
                                        <td style="text-align:right;"><a href="registrieren.php">Registrierung</a></td>
                                </tr>
            		</table>
            	</form>
                </div>
            </div>
			<div id="fuss_login">
			    
			</div>
		</div>
	</body>
</html>