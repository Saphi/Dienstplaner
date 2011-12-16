<div id="hauptinhalt">
<?php


/* Funktion f�r Fehler�berpr�fung */
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
     /* wenn kein Fehler gefunden wurde, Angaben speichern */
	if(count($fehler)=='0')
	{
		$schicht = new Schicht();
		$schicht->schreibe_schicht($_POST['bez'], $_POST['kbez'], $_POST['ab'], $_POST['bis']);
		$erfolg = 'Neue Schicht erfolgreich erstellt.';
	}
}
?>
		<form action="index.php?seite=konfig&sub=neu" method="post">
            <table>
                <tr>
                	<td><h1>Schichtdaten</h1></td>
                </tr>
<?php
if(isset($erfolg))
{
	echo '<tr><td colspan="2" class="erfolg">'.$erfolg.'</td></tr></table>';
}
else
{
	/* wenn Fehler gefunden wurden, Ausgabe der Fehlermeldung */
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
                    <td><input class="feld" type="Text" size="26" name="bez"<?php if(isset($_POST['bez'])) echo ' value="'.$_POST['bez'].'"'; ?>></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['kbez'])) echo 'style="color:red;"'; ?>>* Kurzbezeichnung</td>
                    <td><input class="feld" type="Text" size="26" name="kbez"<?php if(isset($_POST['kbez'])) echo ' value="'.$_POST['kbez'].'"'; ?>></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['ab'])) echo 'style="color:red;"'; ?>>* Startzeit</td>
                    <td><input class="feld" type="Text" size="26" name="ab"<?php if(isset($_POST['ab'])) echo ' value="'.$_POST['ab'].'"'; ?>></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['bis'])) echo 'style="color:red;"'; ?>>* Endzeit</td>
                    <td><input class="feld" type="Text" size="26" name="bis"<?php if(isset($_POST['bis'])) echo ' value="'.$_POST['bis'].'"'; ?>></td>
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