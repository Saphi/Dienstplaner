<?php
session_start();
/* prüfen, ob Benutzer angemeldet ist und somit das Recht hat die Seite zu sehen, sonst umleiten auf anmelden.php */
if($_SESSION['mitarbeiter'])
{
include('inc/config.php');
include('dienstplaner_automatic.php');
/* Mitarbeiterklasse einbinden */
include('klassen/mitarbeiter.klasse.php');
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
			function wochentag($date) //Wochentag durch Datum ermitteln
                        {
                                $date = explode(".", $date);
                                $weekday = mktime(0,0,0,$date[1],$date[0],$date[2]);
                                $day = date('w',$weekday);

                                switch($day)
                                {
                                    case 0:
                                        $day = "So";
                                        break;
                                    case 1:
                                        $day = "Mo";
                                        break;
                                    case 2:
                                        $day = "Di";
                                        break;
                                    case 3:
                                        $day = "Mi";
                                        break;
                                    case 4:
                                        $day = "Do";
                                        break;
                                    case 5:
                                        $day = "Fr";
                                        break;
                                    case 6:
                                        $day = "Sa";
                                        break;
                                }

                                return $day;
			}

                        /*
			$zw = explode("-",$_POST['von']);
     		$start = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
     		$zw = explode("-",$_POST['bis']);
     		$ende = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Enddatum in TT.MM.JJJJ
                         * 
                         */
                $today = date("d.m.Y");
                $zw1 = explode(".",$plan_dates["start"]);
                $zw2 = explode(".",$plan_dates["end"]);
                
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
    			echo '<span class="headline">Dienstplan von <b>'.$plan_dates["start"].'</b> bis <b>'.$plan_dates["end"].'</b></span>';

               echo '<a href="index.php?seite=dienstplan">zur&uuml;ck</a> |';
                echo '<a href="dienstplan_anzeigen.php" onClick="alert("Der Dienstplan wird neu berechnet. Der aktuell angezeigte Dienstplan verf&auml;llt.");">erneut erzeugen</a><br><br>';
               
               echo '<div id="abschliessen"></div>';

               /* wenn Dienstplan f�r alle Mitarbeiter angezeigt werden soll ist anzeige = 1, sonst 0 */
               
               	/* alle Mitarbeiter holen */
                    $ma_sql = $mitarbeiter->hole_alle_mitarbeiter();
              

               /* alle gespeicherten Termine im ausgew�hlten Bereich holen */
    			$termine_sql = get_dates($plan_dates["start"], $plan_dates["end"]);

    			echo '<table class="dienstplan">';
    			echo '<tr>';
   			echo '<th class="dienstplan">&nbsp;</th>';

    			foreach($termine_sql  as $termine)    //Kopfzeile Wochentage
    			{
                                $zw = explode(".",$termine);
                                $tag = $zw[0].'.'.$zw[1].'.';
    				echo '<th class="dienstplan">'.wochentag($termine).'<br/>'.$tag.'</th>';
    			}
    			
    			echo '</tr>';
                        
                         $shifts = $dienstplan_anzeige->get_all_shifts();
                         $schichten_sql = $schichtlegende->hole_alle_schichten();
                         $amount_shifts = sizeof($shifts);

    			foreach($ma_sql as $ma)   //Mitarbeiterspalte
    			{
                           
         			echo '<tr>';
         			echo '<td class="name">'.$ma->last_name.', '.$ma->first_name.'</td>';
                                
         			foreach($termine_sql  as $termine)
    	    			{
                                    
                                    $noentry = 0;
                                    foreach($schichten_sql as $shift)
                                    {
                                            
                                        if(isset($newplan[$termine][$shift->nick]))
                                        {
                                          if(in_array($ma->eid,$newplan[$termine][$shift->nick])){
                                                echo '<td class="schicht" style="background-color:#'.$shift->color.';">'.$shift->nick.'</td>';
                                                break;
                                          }
                                          else
                                          {
                                              $noentry++;
                                              if($noentry == $amount_shifts)
                                              {
                                                  echo '<td> </td>';
                                              }
                                                
                                          }
                                          
                                        }
                                        else
                                        {
                                            $noentry++;
                                              if($noentry == $amount_shifts)
                                              {
                                                  echo '<td> </td>';
                                              }
                                        }
                                              
                                         
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