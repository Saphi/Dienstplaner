<?php
session_start();
/* prüfen, ob Benutzer angemeldet ist und somit das Recht hat die Seite zu sehen, sonst umleiten auf anmelden.php */
if($_SESSION['mitarbeiter'])
{
include('inc/config.php');
/* Mitarbeiterklasse einbinden */
include('klassen/mitarbeiter.klasse.php');
include('klassen/dienstplan.klasse.php');
include('klassen/schicht.klasse.php');
$mitarbeiter = new Mitarbeiter();
$dienstplan_anzeige = new Dienstplan();
$schichtlegende = new Schicht();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Dienstplaner</title>
		<link rel="stylesheet" type="text/css" href="css/main_css.css">
	</head>
	<body>
		
        	<div id="dienstplan">
<?php
			function wochentag($var) //Wochentag durch Datum ermitteln
                        {
                                $temp = explode("-", $var);
				$datum = mktime(0, 0, 0, $temp[1], $temp[2], $temp[0]);
				$wochentag=array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
				return $wochentag[date("w", $datum)];
			}

                        /*
			$zw = explode("-",$_POST['von']);
     		$start = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
     		$zw = explode("-",$_POST['bis']);
     		$ende = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Enddatum in TT.MM.JJJJ
                         * 
                         */
                $today = date("d.m.Y");
                $zw1 = explode(".",$_POST['von']);
                $zw2 = explode(".",$_POST['bis']);
                
                if($zw1[0] != '')
                {
                    $start = $zw1[2].'-'.$zw1[1].'-'.$zw1[0]; //Datumsformat Startdatum in TT.MM.JJJJ
                }else
                {
                    $start = $today;
                }    
                
                if($zw2[0] != '')
                {
                    $ende = $zw2[2].'-'.$zw2[1].'-'.$zw2[0]; //Datumsformat Enddatum in TT.MM.JJJJ
                }else
                {
                    $ende = $today;
                }    

               echo '<div class="logo"></div>';
    			echo '<span class="headline">Dienstplan von <b>'.$_POST['von'].'</b> bis <b>'.$_POST['bis'].'</b></span>';

               echo '<a href="index.php?seite=dienstplan">zur&uuml;ck</a><br><br>';
               
               echo '<div id="abschliessen"></div>';

               /* wenn Dienstplan f�r alle Mitarbeiter angezeigt werden soll ist anzeige = 1, sonst 0 */
               if($_POST['anzeige']==1)
               {
               	/* alle Mitarbeiter holen */
                    $ma_sql = $mitarbeiter->hole_alle_mitarbeiter();
               }
               else
               {
               	/* nur angemeldeten Benutzer holen */
                    $ma_sql[] = $mitarbeiter->hole_mitarbeiter_durch_id($_GET['mid']);
               }

               /* alle gespeicherten Termine im ausgew�hlten Bereich holen */
    			$termine_sql = $dienstplan_anzeige->hole_alle_termine_von_bis($start, $ende);

    			echo '<table class="dienstplan">';
    			echo '<tr>';
   			echo '<th class="dienstplan">&nbsp;</th>';

    			foreach($termine_sql  as $termine)    //Kopfzeile Wochentage
    			{
                                $zw = explode("-",$termine);
                                $tag = $zw[2].'.'.$zw[1].'.';
    				echo '<th class="dienstplan">'.wochentag($termine).'<br/>'.$tag.'</th>';
    			}
    			
    			echo '</tr>';

    			foreach($ma_sql as $ma)   //Mitarbeiterspalte
    			{
                           
         			echo '<tr>';
         			echo '<td class="name">'.$ma->last_name.', '.$ma->first_name.'</td>';

         			foreach($termine_sql  as $termine)
    	    			{
	         			$dienstplan = $dienstplan_anzeige->hole_dienst_durch_termine_mid($termine, $ma->eid);

	         			
                         !empty($dienstplan->date) ? $dienstplan_termin = $dienstplan->date : $dienstplan_termin = ''; 
                                        
                         if($termine ==  $dienstplan_termin) //wenn Schicht eingetragen
	                    {
	                         echo '<td class="schicht" style="background-color:#'.$dienstplan->color.';">'.$dienstplan->nick.'</td>';
                         }
                         else
                         {
                         	echo '<td>&nbsp;</td>';
                         }

         			}
         			
         			echo '</tr>';
    			}

    			echo '</table><br><hr>';

    			$schichten_sql = $schichtlegende->hole_alle_schichten();

    			echo '<table><tr><th>Legende:</th></tr>';

    			foreach($schichten_sql as $schichten)   //Inhalt Legende
    			{
          		$temp = explode(":", $schichten->start);
				$zeitab = mktime($temp[0], $temp[1], $temp[2], 0, 0, 0);
          		$temp = explode(":", $schichten->end);
				$zeitbis = mktime($temp[0], $temp[1], $temp[2], 0, 0, 0);
          		$ab = date("H:i" , $zeitab);
          		$bis = date("H:i" , $zeitbis);
          		echo '<tr><td><div class="farbquad" style="background-color:#'.$schichten->color.'; float:left;"></div>&nbsp;
                            '.$schichten->nick.' - '.$schichten->name.' ('.$ab.' - '.$bis.')</td></tr>';
    			}

    			echo '</table>';
?>
		</div>
	</body>
</html>
<?php
}
else
{
	/* Umleitung auf anmelden.php, wenn kein Benutzer angemeldet ist */
	header('Location: anmelden.php');
}
?>