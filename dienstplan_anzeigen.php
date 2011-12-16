<?php
session_start();
/* pr�fen, ob Benutzer angemeldet ist und somit das Recht hat die Seite zu sehen, sonst umleiten auf anmelden.php */
if($_SESSION['mitarbeiter'])
{
include('inc/config.php');
/* Mitarbeiterklasse einbinden */
include('klassen/mitarbeiter.klasse.php');

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
                        $zw = explode(".",$_POST['von']);
     		$start = $zw[2].'-'.$zw[1].'-'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
     		$zw = explode(".",$_POST['bis']);
     		$ende = $zw[2].'-'.$zw[1].'-'.$zw[0]; //Datumsformat Enddatum in TT.MM.JJJJ

    			echo '<h2>Dienstplan von '.$_POST['von'].' bis '.$_POST['bis'].'</h2>';

               echo '<img src="bilder/pfeil_links.png"><a href="index.php?seite=dienstplan">zur&uuml;ck</a><br><br>';

               /* wenn Dienstplan f�r alle Mitarbeiter angezeigt werden soll ist anzeige = 1, sonst 0 */
               if($_POST['anzeige']==1)
               {
               	/* alle Mitarbeiter holen */
               	$ma_sql = mysql_query("SELECT mid, name, vname FROM mitarbeiter");
               }
               else
               {
               	/* nur angemeldeten Benutzer holen */
                    $ma_sql = mysql_query("SELECT mid, name, vname FROM mitarbeiter WHERE mid = '".$_GET['mid']."'");
               }

               /* alle gespeicherten Termine im ausgew�hlten Bereich holen */
    			$termine_sql = mysql_query("SELECT termin FROM schicht_mitarbeiter WHERE termin BETWEEN '".$start."' AND '".$ende."' GROUP BY termin ORDER BY termin");

    			echo '<table class="dienstplan">';
    			echo '<tr>';
   			echo '<th class="dienstplan">Mitarbeiter</th>';

    			while($termine = mysql_fetch_assoc($termine_sql))    //Kopfzeile Wochentage
    			{
                                $zw = explode("-",$termine['termin']);
                                $tag = $zw[2].'.'.$zw[1].'.';
    				echo '<th class="dienstplan">'.wochentag($termine['termin']).'<br/>'.$tag.'</th>';
    			}
    			mysql_data_seek($termine_sql, 0);
    			echo '</tr>';

    			while($ma = mysql_fetch_assoc($ma_sql))   //Mitarbeiterspalte
    			{
         			echo '<tr>';
         			echo '<td class="name">'.$ma['name'].', '.$ma['vname'].'</td>';

         			while($termine = mysql_fetch_assoc($termine_sql))
    	    			{
	         			$dienstplan_sql = mysql_query("SELECT sma.termin, s.kbez FROM schicht_mitarbeiter sma JOIN schicht s ON sma.sid =s.sid WHERE sma.termin = '".$termine['termin']."' AND mid = '".$ma['mid']."'");

	         			$dienstplan = mysql_fetch_assoc($dienstplan_sql);

                         if($termine['termin'] ==  $dienstplan['termin']) //wenn Schicht eingetragen
	                    {
	                         echo '<td class="schicht">'.$dienstplan['kbez'].'</td>';
                         }
                         else
                         {
                         	echo '<td>&nbsp;</td>';
                         }

         			}
         			mysql_data_seek($termine_sql, 0); //array zr�cksetzen
         			echo '</tr>';
    			}

    			echo '</table><br><hr>';

    			$schichten_sql = mysql_query("SELECT * FROM schicht");

    			echo '<table><tr><th>Legende:</th></tr>';

    			while($schichten = mysql_fetch_assoc($schichten_sql))   //Inhalt Legende
    			{
          		$temp = explode(":", $schichten['ab']);
				$zeitab = mktime($temp[0], $temp[1], $temp[2], 0, 0, 0);
          		$temp = explode(":", $schichten['bis']);
				$zeitbis = mktime($temp[0], $temp[1], $temp[2], 0, 0, 0);
          		$ab = date("H:i" , $zeitab);
          		$bis = date("H:i" , $zeitbis);
          		echo '<tr><td>'.$schichten['kbez'].' - '.$schichten['bez'].' ('.$ab.' - '.$bis.')</td></tr>';
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