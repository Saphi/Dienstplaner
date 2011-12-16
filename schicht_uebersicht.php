<div id="hauptinhalt">
<?php
if(isset($_GET['l'])){
$sid = $_GET['l'];

/* ausgew�hlte Schicht l�schen */
$schicht = new Schicht();
$schicht->loesche_schicht_durch_id($sid);

$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter->loesche_alle_schicht_mitarbeiter_durch_sid($sid);

mysql_query("DELETE FROM schicht_ma WHERE SID='".$sid."'");
}

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
				echo '		<td><a href="index.php?seite=konfig&sub=bearbeiten&sid='.$schicht->sid.'">bearbeiten</a></td>';
				echo '		<td><a href="index.php?seite=konfig&l='.$schicht->sid.'" onclick="return confirm(\'Wollen Sie die Schicht mit all ihren Einstellung wirklich l&ouml;schen?\')">l&ouml;schen</a></td>';
				echo '	</tr>';
                     echo '<tr><td colspan=6><hr></td></tr>';
			}


			echo '</table>';
		}
?>
		

   
</div>