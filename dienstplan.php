<div id="submenu"> </div>

<div id="hauptinhalt">
<?php
/* Zugriff auf Klasse Mitarbeiter um Mitarbeiterdaten zu holen */
$mitarbeiter = new Mitarbeiter();
$mitarbeiter = $mitarbeiter->hole_mitarbeiter_durch_id($_SESSION['mitarbeiter']->eid);

$b_ab = '';
?>

    
<form action="dienstplan_anzeigen.php?mid=<?php echo $mitarbeiter->eid; ?>" method="post" name="dienstplan">
	<table>
     	<tr>
          	<td><h2>Dienstplan erstellen</h2></td>
          </tr>
       
         <tr><td> von</td></tr>
          <tr><td><input class="feld" type="date" size="30" name="von" value="<?php echo $b_ab;  ?>" readonly>
               	<script language="JavaScript">  //Kalender zur Datumsauswahl
        	  			new tcal ({
	                    	'formname': 'dienstplan',
	                         'controlname': 'von'
	                  	});
               	</script></td></tr>
         <tr><td> bis</td></tr>
         <tr><td> <input class="feld" type="date" size="30" name="bis" value="<?php echo $b_ab;  ?>" readonly>
               	<script language="JavaScript">  //Kalender zur Datumsauswahl
        	  			new tcal ({
	                    	'formname': 'dienstplan',
	                         'controlname': 'bis'
	                  	});
               	</script></td></tr>
<?php
	    
         
          echo '<tr><td>';

	     echo '&nbsp;';
          echo '</td></tr>';
          echo '<tr><td>';

          echo '<input type="radio" name="anzeige" value="1" checked="checked"> für alle Mitarbeiter<br />';
          echo '<input type="radio" name="anzeige" value="0" > nur für mich';

          echo '</td></tr>';
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