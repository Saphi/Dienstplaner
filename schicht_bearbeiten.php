<div id="hauptinhalt">
<?php


$sid = $_GET['sid'];

/* Daten der ausgew�hlten Schicht holen */
$schicht_neu = new Schicht();
$schicht = $schicht_neu->hole_schicht_durch_id($sid);

/* pr�fen der Eingaben auf Fehler */
function testen()
{
	$fehler = array();
	if(strlen($_POST['bez'])=='0')
	{
		$fehler['bez'] = 'Bitte geben Sie eine Bezeichnung ein!';
	}
	if(strlen($_POST['kbez'])=='0')
	{
		$fehler['kbez'] = 'Bitte geben Sie eine Kurzbezeichnung ein!';
	}
	if(strlen($_POST['ab'])=='0')
	{
		$fehler['ab'] = 'Bitte geben Sie die Startzeit der Schicht ein!';
	}
	if(strlen($_POST['bis'])=='0')
	{
		$fehler['bis'] = 'Bitte geben Sie die Endzeit der Schicht ein!';
	}
	return $fehler;
}

/* nach Best�tigung der Angaben */
if(isset($_POST['speichern']))
{
	$fehler = testen();
     /* wenn kein Fehler gefunden wurde, speichern der Angaben */
	if(count($fehler)=='0')
	{
		$schicht_neu->erneuere_schicht($sid, $_POST['bez'], $_POST['kbez'], $_POST['ab'], $_POST['bis']);
		$erfolg = 'Schicht erfolgreich aktualisiert.';
	}
}
?>
		<form action="index.php?seite=konfig&sub=bearbeiten&sid=<?php echo $sid; ?>" method="post">
            <table>
                <tr>
                	<td><h2>Schichtdaten</h2></td>
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
		echo '</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
	}
?>
		        <tr>
            		<td colspan="2">* Pflichtfelder</td>
            	</tr>
            	<tr>
            		<td>&nbsp;</td>
            	</tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['bez'])) echo 'style="color:red;"'; ?>>* Bezeichnung</td>
                    <td><input class="feld" type="Text" size="26" name="bez" value="<?php if(isset($_POST['bez'])) echo $_POST['bez']; else echo $schicht->bez; ?>"></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['kbez'])) echo 'style="color:red;"'; ?>>* Kurzbezeichnung</td>
                    <td><input class="feld" type="Text" size="26" name="kbez" value="<?php if(isset($_POST['kbez'])) echo $_POST['kbez']; else echo $schicht->kbez; ?>"></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['ab'])) echo 'style="color:red;"'; ?>>* Startzeit</td>
                    <td><input class="feld" type="Text" size="26" name="ab" value="<?php if(isset($_POST['ab'])) echo $_POST['ab']; else echo $schicht->ab; ?>"></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['bis'])) echo 'style="color:red;"'; ?>>* Endzeit</td>
                    <td><input class="feld" type="Text" size="26" name="bis" value="<?php if(isset($_POST['bis'])) echo $_POST['bis']; else echo $schicht->bis; ?>"></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="knopf_speichern" name="speichern" type="submit" value=" "></td>
                </tr>
            </table>
<?php
}
?>
        </form>
	
    
</div>