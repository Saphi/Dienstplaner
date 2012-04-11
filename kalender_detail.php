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



/* nach Best�tigung der Angaben */
if(isset($_POST['speichern']))
{
	/* prüfen der maximalen Mitarbeiteranzahl */
	if((count($_POST)-3)>$ma_anzahl['must'])
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

if(isset($_GET['l']))
{
    $smid = $_GET['l'];
    $schicht_ma->loesche_schicht_mitarbeiter_durch_smid($smid);
           
}


$mitarbeiter = new Mitarbeiter();
$mitarbeiter_feld = array();
$mitarbeiter_feld = $mitarbeiter->hole_alle_mitarbeiter();

$schicht = new Schicht();
$schicht = $schicht->hole_schicht_durch_id($sid);

$schicht_mitarbeiter = new Schicht_Mitarbeiter();
$schicht_mitarbeiter_feld = $schicht_mitarbeiter->hole_alle_schicht_mitarbeiter_durch_sid_termin($sid, $termin);
?>
<div id="submenu">
     <a href="index.php?seite=kalender&sub=uebersicht">zurück zum Kalender</a>
</div>
<div id="hauptinhalt">

		<form action="index.php?seite=kalender&sub=detail" method="post">
<?php
echo '			<h2>'.$schicht->name.' am '.$tag.'.'.$monat.'.'.$jahr.'</h2>';
echo '			<p>Benötigte Mitarbeiter: '.$ma_anzahl['must'].'</p>';


if(isset($erfolg))
{
	echo '<table><tr><td colspan="2" class="erfolg">'.$erfolg.'</td></tr></table>';
}

	if(isset($fehler))
	{
		echo '<table><tr><td colspan="2" class="fehler">'.$fehler.'</td></tr></table>';
	}
        
        echo '	<table id="top_left" style="height:100px;">';
	echo '	<tr><th colspan="2" style="vertical-align:top">Eingeteilte Mitarbeiter</th></tr>';
	
	$index=0;
	foreach($mitarbeiter_feld as $mitarbeiter)
	{
		$urlaub = new Urlaub();
		$urlaub_feld = $urlaub->hole_urlaub_durch_mid($mitarbeiter->eid);
		$test = 0;
		foreach($schicht_mitarbeiter_feld as $schicht_mitarbeiter)
		{
          	/* prüfen ob Mitarbeiter zum gewählten Termin Urlaub hat, wenn ja wird er nicht aufgelistet */
			if($schicht_mitarbeiter->employees_eid==$mitarbeiter->eid && $schicht_mitarbeiter->date==$termin)
			{
				$test = '1';
			}
		}
                
		if($test=='1')
		{
                        $schicht_mitarbeiter_smid = $schicht_mitarbeiter->hole_smid_durch_sid_termin_mid($sid, $termin, $mitarbeiter->eid);
                        
			echo '<tr><td class="tablerow"><input type="checkbox" name="'.$index.'" value="'.$mitarbeiter->eid.'" style="visibility:hidden;" checked />'.$mitarbeiter->last_name.', '.$mitarbeiter->first_name.'</td>';
                        if($_SESSION['mitarbeiter']->role=='1')
			 {
                        echo '<td class="tablerow"> | <a href="index.php?seite=kalender&sub=detail&l='.$schicht_mitarbeiter_smid['empShiftid'].'&sid='.$sid.'&jahr='.$jahr.'&monat='.$monat.'&tag='.$tag.'">entfernen</a></td></tr>';
                         }
                         
                             echo '</tr>';
                         
			
		}else
                {
                    echo ".";
                }
			
		$index++;
	}
        
        echo '</table><table id="top_right">';
        if($_SESSION['mitarbeiter']->role=='1')
        {
        echo '	<tr><th colspan="2">Mitarbeiter hinzufügen</th></tr>';
        echo '<tr><td><select name="'.$index.'">';
        foreach($mitarbeiter_feld as $mitarbeiter)
	{
		$urlaub = new Urlaub();
		$urlaub_feld = $urlaub->hole_urlaub_durch_mid($mitarbeiter->mid);
		$test = 0;
		foreach($schicht_mitarbeiter_feld as $schicht_mitarbeiter)
		{
          	/* pr�fen ob Mitarbeiter zum gew�hlten Termin Urlaub hat, wenn ja wird er nicht aufgelistet */
			if($schicht_mitarbeiter->employees_eid==$mitarbeiter->eid && $schicht_mitarbeiter->date==$termin)
			{
				$test = '1';
				foreach($urlaub_feld as $urlaub_objekt)
				{
					if($schicht_mitarbeiter->date>$urlaub_objekt->start && $schicht_mitarbeiter->date<$urlaub_objekt->end)
					{
						$test='2';
					}
				}
			}
		}
                
		if($test=='0')
		{
                    echo '<option value="'.$mitarbeiter->eid.'">'.$mitarbeiter->last_name.', '.$mitarbeiter->first_name.'</option>';
		}
                
		$index++;
	}
        echo '</select></td></tr>';
?>
				<tr>
                    <td>
                    	<input type="hidden" name="sid" value="<?php echo $sid; ?>">
                    	<input type="hidden" name="termin" value="<?php echo $jahr.'-'.$monat.'-'.$tag; ?>">
                        <input class="knopf_speichern" type="submit" name="speichern" value=" "></td>
                </tr>
<?php    
        }
                echo '</table>';


?>
		</form>
	</div>
	