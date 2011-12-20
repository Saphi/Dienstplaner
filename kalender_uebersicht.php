<?php
include('klassen/kalender.klasse.php');
include('klassen/schicht.klasse.php');

$kalender = new Kalender();
if(isset($_GET['monat'])&&isset($_GET['jahr']))
{
	$kalender->setze_termin($_GET['monat'], $_GET['jahr']);
	$termin = $_GET['jahr'].'-'.$_GET['monat'].'-'.date('t', mktime(0,0,0,$_GET['monat'],1,$_GET['jahr']));
}
else
{
	$kalender->setze_termin((int)date('m', time()), date('Y', time()));
	$termin = date('Y', time()).'-'.date('m', time()).'-'.date('t', mktime(0,0,0,date('m', time()),1,date('Y', time())));
}
$kalender_feld = $kalender->hole_kalender();
$vor = $kalender->hole_vor_monat();
$nach = $kalender->hole_nach_monat();

$schicht_mitarbeiter_kalender = new Schicht();
$schicht_mitarbeiter_kalender_feld = $schicht_mitarbeiter_kalender->hole_alle_schichten_fuer_kalender();
?>

<div id="submenu">
    <a id="pfeil_links" href="index.php?seite=kalender&sub=uebersicht&monat=<?php echo $vor[0]; ?>&jahr=<?php echo $vor[1]; ?>"></a>
    <span id="kalenderueberschrift"><?php echo $kalender->monats_name[$kalender->monat].' '.$kalender->jahr; ?></span>
    <a id="pfeil_rechts" href="index.php?seite=kalender&sub=uebersicht&monat=<?php echo $nach[0]; ?>&jahr=<?php echo $nach[1]; ?>"></a>

</div>
<div id="hauptinhalt_kal">
		<table>
			
			<tr>
				<th class="kalenderhead">Montag</th>
				<th class="kalenderhead">Dienstag</th>
				<th class="kalenderhead">Mittwoch</th>
				<th class="kalenderhead">Donnerstag</th>
				<th class="kalenderhead">Freitag</th>
				<th class="kalenderhead">Samstag</th>
				<th class="kalenderhead_7">Sonntag</th>
			</tr>
<?php
$test = 0;
$col=0;
$row=1;
foreach($kalender_feld as $woche)
{
    
    
    switch($row){
        case 1: case 2: case 3: case 4: case 5: $row_class = ''; break;
        case 6: $row_class = 'row_6'; break;   
    }
	echo '<tr>';
	foreach($woche as $tag_id => $tag)
	{
            $col++;
            switch($col){
                case 1: case 2: case 3: case 4: case 5: case 6: $col_class = ''; break;
                case 7: $col_class = 'col_7'; break;   
            }
		if($tag=='1')
		{
			$test++;
		}
		if($test!='1')
		{
			echo '<td class="kalenderfeld '.$col_class.' '.$row_class.'" style="color:#acacac;"><span>'.$tag.'</span></td>';
		}
		else
		{
			$kalender_termin = $kalender->jahr.'-'.$kalender->monat.'-'.$tag;
			echo '<td class="kalenderfeld '.$col_class.' '.$row_class.'" style="color:#150e7e;"><span>'.$tag.'</span>';
			if(isset($schicht_mitarbeiter_kalender_feld[$tag_id+1]))
			{
				foreach($schicht_mitarbeiter_kalender_feld[$tag_id+1] as $schluessel => $schicht_mitarbeiter_kalender)
				{
					if($schluessel%3==0)
					{
						$ausgabe_sid = $schicht_mitarbeiter_kalender->sid;
						$ausgabe =  $schicht_mitarbeiter_kalender->kbez;
					}
					if($schluessel%3==1)
					{
						$von = 0;
						foreach($schicht_mitarbeiter_kalender as $schicht_mitarbeiter)
						{
							if(isset($schicht_mitarbeiter) && $schicht_mitarbeiter->termin==$kalender_termin)
							{
								$von = $von + 1;
							}
						}
						$ausgabe.= ' ('.$von.'|';
					}
					if($schluessel%3==2)
					{
						$bis = $schicht_mitarbeiter_kalender['0']['2'];
						$ausgabe .= $bis.')</div></a>';
						if($von=='0'&&$bis>0)
						{
							echo '<a href="index.php?seite=kalender&sub=detail&sid='.$ausgabe_sid.'&jahr='.$kalender->jahr.'&monat='.$kalender->monat.'&tag='.$tag.'"><div style="background:#ffdddd;padding:0px 1px;">'.$ausgabe;
						}
						if($von>'0'&&$bis>'0'&&$von<$bis)
						{
							echo '<a href="index.php?seite=kalender&sub=detail&sid='.$ausgabe_sid.'&jahr='.$kalender->jahr.'&monat='.$kalender->monat.'&tag='.$tag.'"><div style="background:#fffccf;padding:0px 1px;">'.$ausgabe;
						}
						if($von>'0'&&$bis>'0'&&$von==$bis)
						{
							echo '<a href="index.php?seite=kalender&sub=detail&sid='.$ausgabe_sid.'&jahr='.$kalender->jahr.'&monat='.$kalender->monat.'&tag='.$tag.'"><div style="background:#ddffdd;padding:0px 1px;">'.$ausgabe;
						}
					}
				}
			}
			echo '</td>';
		}
            if($col==7){
                $col=0;
                $row++;
            }
	}
	echo '</tr>';
}
?>
		</table>
	

</div>
