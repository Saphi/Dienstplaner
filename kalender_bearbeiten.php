<?php
include('klassen/schicht.klasse.php');
if($_GET['tag']<10 && substr($_GET['monat'],0,1)!='0')
{
	$tag = '0'.$_GET['tag'];
}
else
{
	$tag = $_GET['tag'];
}
if($_GET['monat']<10 && substr($_GET['monat'],0,1)!='0')
{
	$monat = '0'.$_GET['monat'];
}
else
{
	$monat = $_GET['monat'];
}
$jahr = $_GET['jahr'];
$termin = $jahr.'-'.$monat.'-'.$tag;

if(isset($_POST['speichern']))
{
	$schicht_termin_neu = new Schicht();
	$schicht_termin_neu->schreibe_schicht_termin($_POST, $termin);
}

$schicht_neu = new Schicht();
$schichten_objekt_feld = $schicht_neu->hole_alle_schichten();

$schicht_termin = new Schicht();
if($schicht_termin->hole_alle_schichten_durch_termin($termin))
{
	$schichten_termin_objekt_feld = $schicht_termin->hole_alle_schichten_durch_termin($termin);
}
?>
		<h1>Schichten hinzuf�gen f�r den: <?php echo $tag.'.'.$monat.'.'.$jahr; ?></h1>
<?php
		echo '<form action="index.php?seite=kalender_bearbeiten&tag='.$tag.'&monat='.$monat.'&jahr='.$jahr.'" method="post">';
		echo '	<table>';
		echo '		<tr>';
		echo '			<th>&nbsp;</th>';
		echo '			<th>von</th>';
		echo '			<th>bis</th>';
		echo '			<th>Bezeichnung</th>';
		echo '		</tr>';
				
		if(isset($schichten_termin_objekt_feld))
		{
			foreach($schichten_termin_objekt_feld as $schicht_termin)
			{
				$schicht_id_feld[] = $schicht_termin->sid;
			}
		}
		else
		{
			$schicht_id_feld = array();
		}
		foreach($schichten_objekt_feld as $schicht)
		{
			echo '		<tr>';
			
			if(in_array($schicht->sid, $schicht_id_feld))
			{
				echo '			<td><input type="checkbox" name="'.$schicht->sid.'" value="1" checked="checked"></td>';
			}
			else
			{
				echo '			<td><input type="checkbox" name="'.$schicht->sid.'" value="0"></td>';
			}
			echo '			<td>'.$schicht->ab.'</td>';
			echo '			<td>'.$schicht->bis.'</td>';
			echo '			<td>'.$schicht->bez.'</td>';
			echo '		</tr>';
		}

		echo '	</table>';
?>
			<br>
			<input class="knopf" name="speichern" type="submit" value="Best&auml;tigen">
		</form>		
	</div>
	<br id="abschliessen">
</div>
<div id="fuss">
    
</div>