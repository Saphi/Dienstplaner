<div id="hauptinhalt">
<?php
/* wenn angemeldeter Benutzer keine Admin-Rechte hat, nur dessen Mitarbeiterdaten holen
   wenn Benuter Admin-Rechte hat, alle Mitarbeiterdaten holen */

/*
($_SESSION['mitarbeiter']->recht!='1')
{
	$mitarbeiter_feld[] = $mitarbeiter->hole_mitarbeiter_durch_id($_SESSION['mitarbeiter']->mid);
}
else
{
	$mitarbeiter_feld = $mitarbeiter->hole_alle_mitarbeiter();
}
*/
    $mitarbeiter_feld = $mitarbeiter->hole_alle_mitarbeiter();


		if(isset($mitarbeiter_feld))     //Tabellenkopf
		{
			echo '<table>';
			echo '	<tr>';
			echo '		<th>Aktiv</th>';
			echo '		<th>Name</th>';
			echo '		<th>Abteilung</th>';
                        echo '		<th>Kommentar</th>';
			echo '		<th>Rechte</th>';
			echo '		<th colspan="3">&nbsp;</th>';
			echo '	</tr>';

			foreach($mitarbeiter_feld as $mitarbeiter)  //Tabelleninhalt für jeden Mitarbeiter
			{
				echo '<tr class="hr"><td colspan=7><hr></td></tr>';
                                echo '	<tr>';
				if($mitarbeiter->active=='1')
				{
                                    if($_SESSION['mitarbeiter']->role=='1')
                                    {
                                        echo '<td> <a href="index.php?seite=mitarbeiter&action=a&mid='.$mitarbeiter->eid.'" class="ma_aktiv"> </a> </td>';
                                    }
                                    else
                                    {
                                        echo '		<td class="ma_aktiv"></td>';
                                    }
				}
				else
				{
                                    if($_SESSION['mitarbeiter']->role=='1')
                                    {
                                        echo '<td> <a href="index.php?seite=mitarbeiter&action=a&mid='.$mitarbeiter->eid.'" class="ma_inaktiv"> </a> </td>';
                                    }
                                    else
                                    {
                                        echo '		<td class="ma_inaktiv"></td>';
                                    }
				}
				echo '		<td>'.$mitarbeiter->last_name.', '.$mitarbeiter->first_name.'</td>';
				echo '		<td> x </td>';
                                echo '		<td> x </td>';
				if($mitarbeiter->role=='1')
				{
					echo '		<td>Admin</td>';
				}
				else
				{
					echo '		<td>Mitarbeiter</td>';
				}
                    /* Benuter ohne Admin-Rechte haben nur Zugriff auf die bearbeiten-schaltfläche */
                                echo '		<td style="text-align:right;">';
				/*
                                if($mitarbeiter->aktiv=='1' && $_SESSION['mitarbeiter']->recht=='1')
				{
					echo '<a href="index.php?seite=mitarbeiter&action=a&mid='.$mitarbeiter->mid.'">Deaktivieren</a> | ';
				}
				if($mitarbeiter->aktiv=='0' && $_SESSION['mitarbeiter']->recht=='1')
				{
					echo '<a href="index.php?seite=mitarbeiter&action=a&mid='.$mitarbeiter->mid.'">Aktivieren</a> | ';
				}
                                 
                                 */
                                echo '<a href="index.php?seite=mitarbeiter&sub=details&mid='.$mitarbeiter->eid.'">Details</a>';
                                if($_SESSION['mitarbeiter']->eid == $mitarbeiter->eid || $_SESSION['mitarbeiter']->role=='1')
                                {
					echo ' | <a href="index.php?seite=mitarbeiter&sub=bearbeiten&mid='.$mitarbeiter->eid.'">Bearbeiten</a>';
				}
                                if($_SESSION['mitarbeiter']->role=='1')
				{
					echo ' | <a href="index.php?seite=mitarbeiter&action=l&mid='.$mitarbeiter->eid.'" onclick="return confirm(\'Wollen Sie den Mitarbeiter und dessen Schichtzuweisungen wirklich löschen?\')">L&ouml;schen</a>';
				}
				else
				{
					echo '		<td>&nbsp;</td>';
				}
				echo '	</td></tr>';
                   
			}
			echo '</table>';
		}
          
?>
</div>