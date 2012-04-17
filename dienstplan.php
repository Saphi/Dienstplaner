<div id="submenu"> </div>

<div id="hauptinhalt">
<?php
/* Zugriff auf Klasse Mitarbeiter um Mitarbeiterdaten zu holen */
$mitarbeiter = new Mitarbeiter();
$mitarbeiter = $mitarbeiter->hole_mitarbeiter_durch_id($_SESSION['mitarbeiter']->eid);

$b_ab = '';
?>

    
<form action="dienstplan_anzeigen.php" method="post" name="dienstplan">
	<table>
     	<tr>
          	<td><h2>Dienstplan erstellen</h2></td>
          </tr>

<?php
	 
          echo '<tr><td>';

	     echo '&nbsp;';
          echo '</td></tr>';
          echo '<tr><td>';

	     echo '<input class="knopf_erstellen" type="submit" name="speichern" value=" ">';
          echo '</td></tr>';
?>
	</table>
</form>

</div>