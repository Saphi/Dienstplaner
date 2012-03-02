<div id="hauptinhalt">
<?php
if(isset($_GET['l'])){
$sid = $_GET['l'];

/* ausgew�hlte Schicht l�schen */
$schicht = new Schicht();
$schicht->loesche_schicht_durch_id($sid);

$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter->loesche_alle_schicht_mitarbeiter_durch_sid($sid);

mysql_query("DELETE FROM shift_must WHERE sid='".$sid."'");
}

/* alle Schichtdaten holen */
$schichten = new Schicht();
$schichten_array = $schichten->hole_alle_schichten();

		if(isset($schichten_array))      // Tabellenkopf
		{
			echo '<table>';
			echo '	<tr>';
                        echo '		<th>&nbsp;</th>';
			echo '		<th>Bezeichnung</th>';
			echo '		<th>Abk&uuml;rzung</th>';
			echo '		<th>von</th>';
			echo '		<th>bis</th>';
			echo '		<th colspan="2">&nbsp;</th>';
			echo '	</tr>';

			foreach($schichten_array as $schicht)    // Tabelleninhalt
			{
                                $temp = explode(":", $schicht->start);
                                $zeitab = mktime($temp[0], $temp[1], $temp[2], 0, 0, 0);
                                $temp = explode(":", $schicht->end);
				$zeitbis = mktime($temp[0], $temp[1], $temp[2], 0, 0, 0);
                                $ab = date("H:i" , $zeitab);
                                $bis = date("H:i" , $zeitbis);
				echo '<tr class="hr"><td colspan=7><hr></td></tr>';
                                echo '	<tr>';
                                echo '		<td><div class="farbquad" style="background-color:#'.$schicht->color.';"></div></td>';
				echo '		<td>'.$schicht->name.'</td>';
				echo '		<td>'.$schicht->nick.'</td>';
				echo '		<td>'.$ab.'</td>';
				echo '		<td>'.$bis.'</td>';
				echo '		<td style="text-align:right;"><a href="index.php?seite=konfig&sub=bearbeiten&sid='.$schicht->sid.'">Bearbeiten</a> ';
				echo '		| <a href="index.php?seite=konfig&l='.$schicht->sid.'" onclick="return confirm(\'Wollen Sie die Schicht mit all ihren Einstellung wirklich l&ouml;schen?\')">L&ouml;schen</a></td>';
				echo '	</tr>';
                     
			}


			echo '</table>';
		}
?>
		

   
</div>