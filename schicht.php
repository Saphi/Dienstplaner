<?php
/* Klasse Schicht einbinden */
include('klassen/schicht.klasse.php');

/* alle Schichtdaten holen */
$schichten = new Schicht();
$schichten_array = $schichten->hole_alle_schichten();

		if(isset($schichten_array))      // Tabellenkopf
		{
			echo '<table>';
			echo '	<tr>';
			echo '		<th>Bezeichnung</th>';
			echo '		<th>Abk&uuml;rzung</th>';
			echo '		<th>von</th>';
			echo '		<th>bis</th>';
			echo '		<th colspan="2">&nbsp;</th>';
			echo '	</tr>';

			foreach($schichten_array as $schicht)    // Tabelleninhalt
			{
				echo '	<tr>';
				echo '		<td>'.$schicht->bez.'</td>';
				echo '		<td>'.$schicht->kbez.'</td>';
				echo '		<td>'.$schicht->ab.'</td>';
				echo '		<td>'.$schicht->bis.'</td>';
				echo '		<td><a href="index.php?seite=schicht_bearbeiten&sid='.$schicht->sid.'">bearbeiten</a></td>';
				echo '		<td><a href="index.php?seite=schicht_loeschen&sid='.$schicht->sid.'" onclick="return confirm(\'Wollen Sie die Schicht mit all ihren Einstellung wirklich löschen?\')">löschen</a></td>';
				echo '	</tr>';
                     echo '<tr><td colspan=6><hr></td></tr>';
			}


			echo '</table>';
		}
?>
		<br><br>
		<a href="index.php?seite=schicht_neu" class="knopf_auswahl"><div class="knopf_auswahl_text">neue Schicht</div></a>
	</div>
	<br id="abschliessen">
</div>
<div id="fuss">
    <div id="fuss_text">
        Hier k&ouml;nnen Sie ausw&auml;hlen, ob Sie eine neue Schicht erstellen<br>
        oder eine bereits vorhandene Schicht bearbeiten oder löschen wollen.
    </div>
</div>