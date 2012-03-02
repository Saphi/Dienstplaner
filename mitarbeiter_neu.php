<div id="hauptinhalt">
<?php


/* Eingaben auf Fehler pr�fen */
function testen($mitarbeiter)
{
	$fehler = array();
	if(strlen($_POST['name'])=='0')
	{
		$fehler['name'] = 'Bitte geben Sie einen Namen ein!';
	}
	if(strlen($_POST['vname'])=='0')
	{
		$fehler['vname'] = 'Bitte geben Sie einen Vornamen ein!';
	}
	if(strlen($_POST['email'])>'0' && Mitarbeiter::teste_email($_POST['email']) && $_POST['email']!= $mitarbeiter->email)
	{
		$fehler['email'] = 'Ihre E-Mail ist bereits registriert!';
	}
	if(strlen($_POST['email'])=='0')
	{
		$fehler['email'] = 'Bitte geben Sie eine E-Mail ein!';
	}
	if(strlen($_POST['pw'])=='0')
	{
		$fehler['pw'] = 'Bitte geben Sie ein Passwort ein!';
	}
	return $fehler;
}

/* nach Bestätigung der Angaben */
if(isset($_POST['speichern']))
{

	$fehler = testen($mitarbeiter);
     /* wenn kein Fehler gefunden wurde, speichern der Angaben */
	if(count($fehler)=='0')
	{
		$pw = md5($_POST['pw']);
                
                $adresse = '';
                if(!empty($_POST['adresse'])) $adresse = $_POST['adresse'];
                $city = '';
                if(!empty($_POST['city'])) $city = $_POST['city'];
                
		$mitarbeiter->schreibe_mitarbeiter($_POST['name'], $_POST['vname'], $adresse, $city, $_POST['tel'], $_POST['email'], $_POST['max_h_d'], $_POST['max_h_w'], $_POST['max_u'], $_POST['recht'], $pw);
		$erfolg = 'Neuer Mitarbeiter erfolgreich erstellt.<br>Damit der Mitarbeiter sich anmelden kann muss er noch aktiviert werden.';
	}
}
?>


		<form action="index.php?seite=mitarbeiter&sub=neu" method="post">
<?php
if(isset($erfolg))
{
	echo '<table><tr><td colspan="2" class="erfolg">'.$erfolg.'</td></tr></table>';
}
else
{
	/* wenn Fehler gefunden wurde, Ausgabe der Fehlermeldung */
	if(isset($fehler) && count($fehler)>'0')
	{
		echo '<table><tr><td colspan="2" class="fehler">';
		foreach($fehler as $einzelfehler)
		{
			echo $einzelfehler.'<br>';
		}
		echo '</td></tr></table>';
	}
}
?>
            <table id="top_left">
                <tr>
                	<td colspan=2><h2>Person</h2></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['name'])) echo 'style="color:red;"'; ?>>* Name</td>
                    <td class="beschriftung"<?php if(isset($fehler['vname'])) echo 'style="color:red;"'; ?>>* Vorname</td>
                </tr>
                <tr>
                    <td><input class="feld" type="Text" size="25" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"></td>
                    <td><input class="feld" type="Text" size="25" name="vname" value="<?php if(isset($_POST['vname'])) echo $_POST['vname']; ?>"></td>
                </tr>
                <tr>
                	<td class="beschriftung"<?php if(isset($fehler['pw'])) echo 'style="color:red;"'; ?>>* Passwort</td>
<?php                   if($_SESSION['mitarbeiter']->role=='1')
			 {
			     	echo '<td class="beschriftung">Admin</td>';
                         }
                         else
                         {
                                echo '<td></td>';
                         }
?>

                </tr>
                <tr>
                        <td><input class="feld" type="password" size="25" name="pw" value="<?php if(isset($_POST['pw'])) echo $_POST['pw']; ?>"></td>
<?php
			/* nur Administrator, darf Recht, Arbeitsstunden und Urlaub bearbeiten */
                if($_SESSION['mitarbeiter']->role=='1')
			 {

                                echo '<td>';
                                    echo '<input type="radio" name="recht" value="1" ';

                                    echo '> ja &nbsp;';
                                    echo '<input type="radio" name="recht" value="0" ';
                                     echo 'checked="checked"';
                                    echo '> nein';

                                    echo '<input type="hidden" name="aktiv" value="0">';
				echo '</td>';

                        }
                       else
                       {
                            echo '<td> </td>';
                       }
               echo '</tr>';
?>
        </table>
        <table id="top_right">
                <tr>
                	<td colspan=2><h2>Kontaktdaten</h2></td>
                </tr>
                <tr>
                    <td class="beschriftung">Stra&szlig;e, Hausnr.</td>
                    <td class="beschriftung">PLZ, Ort</td>
                </tr>
                <tr>
                    <td><input class="feld" type="Text" size="25" name="adresse" value="<?php if(isset($_POST['adresse'])) echo $_POST['adresse']; ?>"></td>
                    <td><input class="feld" type="Text" size="25" name="city" value="<?php if(isset($_POST['city'])) echo $_POST['city']; ?>"></td>
                </tr>
		<tr>
                    <td class="beschriftung"<?php if(isset($fehler['email'])) echo 'style="color:red;"'; ?>>* E-Mail</td>
                    <td class="beschriftung">Tel.</td>
                </tr>
                <tr>
                    <td><input class="feld" type="Text" size="25" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"></td>
                    <td><input class="feld" type="Text" size="25" name="tel" value="<?php if(isset($_POST['tel'])) echo $_POST['tel']; ?>"></td>
                </tr>

<?php
			/* nur Administrator, darf Recht, Arbeitsstunden und Urlaub bearbeiten */
                if($_SESSION['mitarbeiter']->role=='1')
			 {

?>

        </table>
        <div id="abschliessen"></div>
        <table id="bottom_left">
                <tr>
                	<td colspan=2><h2>Arbeitsstunden</h2></td>
                </tr>
                <tr>
                    <td class="beschriftung">Tag</td>
                    <td class="beschriftung">Woche</td>
                </tr>
		<tr>
                    <td><input class="feld" type="Text" size="5" name="max_h_d" value="<?php if(isset($_POST['max_h_d'])) echo $_POST['max_h_d']; ?>"></td>
                    <td><input class="feld" type="Text" size="5" name="max_h_w" value="<?php if(isset($_POST['max_h_w'])) echo $_POST['max_h_w']; ?>"></td>
                </tr>

	</table>
        <table id="bottom_right">
                <tr>
                	<td><h2>Urlaubstage</h2></td>
                        <td></td>
                </tr>
                <tr>
                    <td class="beschriftung">Urlaubstage pro Jahr</td>
                    <td></td>
                </tr>
                <tr>
                    <td><input class="feld" type="Text" size="26" name="max_u" value="<?php if(isset($_POST['max_u'])) echo $_POST['max_u']; ?>"></td>
                    <td></td>
                </tr>

<?php
			}
?>
           </table>
           <div id="abschliessen"></div>

                    <input class="knopf_speichern" type="submit" name="speichern" value=" ">

<?php

?>
        </form>

	</div>