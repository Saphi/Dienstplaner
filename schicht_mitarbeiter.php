<?php
/* Klassen Schicht und Urlaub einbinden */
include('klassen/schicht.klasse.php');
include('klassen/urlaub.klasse.php');

if(isset($_GET['sid']) && isset($_GET['tag']) && isset($_GET['monat']) && isset($_GET['jahr']))
{
	$sid = $_GET['sid'];
	$tag = $_GET['tag'];
	$monat = $_GET['monat'];
	$jahr = $_GET['jahr'];
	$termin = $jahr.'-'.$monat.'-'.$tag;
}
else
{
	$sid = $_POST['sid'];
	$termin = $_POST['termin'];
	$tag = substr($_POST['termin'], 8, 2);
	$monat = substr($_POST['termin'], 5, 2);
	$jahr = substr($_POST['termin'], 0, 4);
}

$tid = date('w', mktime(0, 0, 0, $monat, $tag, $jahr));

/* Mitarbeiteranzahl anhand von Tag und Schicht holen */
$schicht_ma = new Schicht_Mitarbeiter();
$ma_anzahl = $schicht_ma->hole_mitarbeiter_anzahl_durch_id($sid, $tid);

/* nach Bestätigung der Angaben */
if(isset($_POST['speichern']))
{
	/* prüfen der maximalen Mitarbeiteranzahl */
	if((count($_POST)-3)>$ma_anzahl['ma'])
	{
		$fehler = 'Sie können nicht soviele Mitarbeiter der Schicht hinzufügen!';
	}
	else
	{
     	/* wenn maximale Anzahl nicht überschritten, speichern der Angaben */
		$schicht_mitarbeiter = new Schicht_Mitarbeiter();
		$schicht_mitarbeiter->loesche_schicht_mitarbeiter_durch_sid_termin($_POST['sid'], $termin);
		foreach($_POST as $schluessel => $schicht_mitarbeiter)
		{
			if(is_numeric($schluessel))
			{
				$schicht_mitarbeiter = new Schicht_Mitarbeiter();
				$schicht_mitarbeiter->schreibe_schicht_mitarbeiter($_POST['sid'], $_POST[$schluessel], $_POST['termin']);
			}
		}
		$erfolg = 'Mitarbeiter in dieser Schicht wurden aktualisiert!';
	}
}

$mitarbeiter = new Mitarbeiter();
$mitarbeiter_feld = array();
$mitarbeiter_feld = $mitarbeiter->hole_alle_mitarbeiter();

$schicht = new Schicht();
$schicht = $schicht->hole_schicht_durch_id($sid);

$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter_feld = $schicht_mitarbeiter->hole_alle_schicht_mitarbeiter_durch_sid_termin($sid, $termin);
?>


		<form action="index.php?seite=schicht_mitarbeiter" method="post">
<?php
echo '			<h1>Benutzer hinzufügen: '.$schicht->bez.' am '.$tag.'.'.$monat.'.'.$jahr.'</h1>';
echo '			<p>Maximale Mitarbeiteranzahl der Schicht: '.$ma_anzahl['ma'].'</p>';
echo '				<table>';
echo '					<tr>';
if(isset($erfolg))
{
	echo '<tr><td colspan="3" class="erfolg">'.$erfolg.'</td></tr></table>';
}
else
{
	if(isset($fehler))
	{
		echo '<tr><td colspan="3" class="fehler">'.$fehler.'</td></tr>';
	}

	echo '						<th>&nbsp;</th>';
	echo '						<th>Name</th>';
	echo '						<th>Vorname</th>';
	echo '					</tr>';
	$index=0;
	foreach($mitarbeiter_feld as $mitarbeiter)
	{
		$urlaub = new Urlaub();
		$urlaub_feld = $urlaub->hole_urlaub_durch_mid($mitarbeiter->mid);
		$test = 0;
		foreach($schicht_mitarbeiter_feld as $schicht_mitarbeiter)
		{
          	/* prüfen ob Mitarbeiter zum gewählten Termin Urlaub hat, wenn ja wird er nicht aufgelistet */
			if($schicht_mitarbeiter->mid==$mitarbeiter->mid && $schicht_mitarbeiter->termin==$termin)
			{
				$test = '1';
				foreach($urlaub_feld as $urlaub_objekt)
				{
					if($schicht_mitarbeiter->termin>$urlaub_objekt->ab && $schicht_mitarbeiter->termin<$urlaub_objekt->bis)
					{
						$test='2';
					}
				}
			}
		}
		if($test!='2')
		{
			if($test=='1')
			{
				echo '					<tr><td><input type="checkbox" name="'.$index.'" value="'.$mitarbeiter->mid.'" checked="checked"></td>';
			}
			else
			{
				echo '					<tr><td><input type="checkbox" name="'.$index.'" value="'.$mitarbeiter->mid.'"></td>';
			}
			echo '					<td>'.$mitarbeiter->name.'</td>';
			echo '					<td>'.$mitarbeiter->vname.'</td>';
			echo '				</tr>';
		}
		$index++;
	}
?>
				<tr>
                    <td>
                    	<input type="hidden" name="sid" value="<?php echo $sid; ?>">
                    	<input type="hidden" name="termin" value="<?php echo $jahr.'-'.$monat.'-'.$tag; ?>">
                    </td>
                    <td><input class="knopf" type="submit" name="speichern" value="Best&auml;tigen"></td>
                </tr>
			</table>
<?php
}
?>
		</form>
	</div>
	<br id="abschliessen">
</div>
<div id="fuss">
    <div id="fuss_text">
        Hier werden Mitarbeiter der zuvor ausgewählten Schicht zugewiesen.
    </div>
</div>