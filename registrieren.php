<?php
include('inc/config.php');

/* Klasse Mitarbeiter einbinden */
include('klassen/mitarbeiter.klasse.php');

/* Eingaben auf Fehler pr�fen */
function testen()
{
	$fehler = array();
	if(strlen($_POST['name'])=='0' || $_POST['name']== "Name")
	{
		$fehler['name'] = 'Bitte geben Sie einen Namen ein!';
	}
	if(strlen($_POST['vname'])=='0' || $_POST['vname']== "Vorname")
	{
		$fehler['vname'] = 'Bitte geben Sie einen Vornamen ein!';
	}
	if(strlen($_POST['email'])>'0' && Mitarbeiter::teste_email($_POST['email']))
	{
		$fehler['email'] = 'Ihre E-Mail ist bereits registriert!';
	}
	if(strlen($_POST['email'])=='0' || $_POST['email'] == "EMail")
	{
		$fehler['email'] = 'Bitte geben Sie eine E-Mail ein!';
	}
	if(strlen($_POST['pw'])=='0' || $_POST['pw'] == "Passwort")
	{
		$fehler['pw'] = 'Bitte geben Sie ein Passwort ein!';
	}

	return $fehler;
}

$mitarbeiter = new Mitarbeiter();

/*nach Best�tigung der Angaben */
if(isset($_POST['speichern']))
{
	/* wenn kein Fehler gefunden wurde, speichern der Angaben */
	$fehler = testen();
	if(count($fehler)=='0')
	{
                if($_POST['adresse'] == "Adresse"){ $adresse = "";}else{$adresse = $_POST['adresse'];}
                if($_POST['tel'] == "Tel"){ $tel = "";}else{$tel = $_POST['tel'];}
		$mitarbeiter->schreibe_mitarbeiter($_POST['name'], $_POST['vname'], $adresse, $tel, $_POST['email'], "", "", "", "", 0, md5($_POST['pw']), 0);
		$erfolg = 'Ihre Registrierung war erfolgreich.<br>Sie k�nnen sich jedoch erst anmelden, wenn der Administrator Sie aktiviert hat.';
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Dienstplaner</title>
		<link rel="stylesheet" type="text/css" href="css/main_css.css">
	</head>
	<body>
		
        <div id="seite_registrieren">
        	<div id="kopf_login">
            	<a href="index.php" id="logo"></a>
            </div>
           <div id="hauptbereich_login">
                <div id="content_login">
            	<form action="registrieren.php" method="post" id="zentriert">
		            <table>
		                <tr>
		                	<td colspan=2><h1>Registrieren</h1></td>
		                </tr>
<?php
if(isset($erfolg))
{
	echo '<tr><td colspan="2" class="erfolg">'.$erfolg.'</td></tr></table>';
}
else
{
	/* wenn Fehler gefunden wurde, Ausgabe der Fehlermeldung */
	if(isset($fehler) && count($fehler)>'0')
	{
		echo '<tr><td colspan="2" class="fehler">';
		foreach($fehler as $einzelfehler)
		{
			echo $einzelfehler.'<br>';
		}
		echo '</td></tr>';
	}

        if($_POST['name']!=''){$name=$_POST['name'];}else{$name="Name";}
        if($_POST['vname']!=''){$vname=$_POST['vname'];}else{$vname="Vorname";}
        if($_POST['adresse']!=''){$adresse=$_POST['adresse'];}else{$adresse="Adresse";}
        if($_POST['email']!=''){$email=$_POST['email'];}else{$email="EMail";}
        if($_POST['tel']!=''){$tel=$_POST['tel'];}else{$tel="Tel";}
        if($_POST['pw']!=''){$pw=$_POST['pw'];}else{$pw="Passwort";}
?>
		                
                <tr>
                    <td colspan="2"><input class="feld" type="Text" size="41" name="name"<?php echo ' value="'.$name.'"'; ?> onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"> *</td>
                </tr>
                <tr>
                    <td colspan="2"><input class="feld" type="Text" size="41" name="vname"<?php echo ' value="'.$vname.'"'; ?> onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"> *</td>
                </tr>
                <tr>
                    <td colspan="2"><input class="feld" type="Text" size="41" name="adresse"<?php echo ' value="'.$adresse.'"'; ?> onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="feld" type="Text" size="41" name="email"<?php echo ' value="'.$email.'"'; ?> onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"> *</td>
                </tr>
                <tr>
                    <td colspan="2"><input class="feld" type="Text" size="41" name="tel"<?php echo ' value="'.$tel.'"'; ?> onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="feld" type="password" size="41" name="pw"<?php echo ' value="'.$pw.'"'; ?> onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;"> *</td>
                </tr>
                <tr>
                    <td colspan="2" class="info">Die mit * gekennzeichneten Felder sind Pflichtfelder.</td>
                </tr>
                <tr>
                    <td><input class="knopf_registrieren" type="submit" name="speichern" value=" "></td>
                    <td style="text-align:right;"><a href="anmelden.php">Anmelden</a></td>
                </tr>
            </table>
<?php
}
?>
		        </form>
                        </div>
            </div>
			<div id="fuss_login">
			    
			</div>
		</div>
	</body>
</html>