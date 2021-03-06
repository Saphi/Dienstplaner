<div id="hauptinhalt">
<?php
include('inc/config.php');
include('klassen/urlaub.klasse.php');

$mid = '';

if(!empty($_POST['mid'])) $mid = $_POST['mid'];
if($mid==''){
    if(!empty($_GET['mid'])) $mid = $_GET['mid'];
}

if($mid==''){
$mid = $_SESSION['mitarbeiter']->eid;
}

$b_ab = '';
$b_bis = '';
$b_tage = '';

$mitarbeiter = new Mitarbeiter();
$urlaub = new Urlaub();

$mitarbeiter_auswahl_feld = $mitarbeiter->hole_alle_mitarbeiter();
?>
<form name="auswahl" action="" method="post">
<select name="mid" onchange="this.form.submit();">
<option value="">- Benutzer ausw&auml;hlen -</option>
<?php
foreach($mitarbeiter_auswahl_feld as $mitarbeiter_auswahl)
{
    if($_SESSION['mitarbeiter']->eid==$mitarbeiter_auswahl->eid || $_SESSION['mitarbeiter']->role==1)
    {
        echo '<option value="'.$mitarbeiter_auswahl->eid.'" ';
        if($mid==$mitarbeiter_auswahl->eid) echo 'selected';
        echo ' >'.$mitarbeiter_auswahl->last_name.', '.$mitarbeiter_auswahl->first_name.'</option>';
    }
}
?>
</select>
</form>
<?php
if($mid!='')
{

/* Daten des ausgewählten Mitarbeiters holen */
$mitarbeiter = $mitarbeiter->hole_mitarbeiter_durch_id($mid);

$anzahl_urlaub = 0;
if(!empty($_POST['anzahl'])) $anzahl_urlaub = $_POST['anzahl'];


$anzahl_urlaubstage = mysql_fetch_array(mysql_query('SELECT sum(amount_days) FROM employee_vac WHERE eid = "'.$mid.'" GROUP BY eid'));
/* Resturlaub berechnen */
$resturlaub =  $mitarbeiter->max_vac - $anzahl_urlaubstage[0];
$restu_post = $resturlaub - $anzahl_urlaub;

if(isset($_GET['l'])) //wenn ein Urlaubseintrag gelöscht wird
{
	mysql_query('DELETE FROM employee_vac WHERE vid = '.$_GET['l'].' LIMIT 1');
}
if(isset($_GET['b'])) //wenn ein Urlaubseintrag bearbeitet wird
{
        
        
	$urlaub_bearbeiten_feld = $urlaub->hole_urlaub_durch_uid($_GET['b']);
        foreach ($urlaub_bearbeiten_feld as $urlaub_bearbeiten) {
            $zw = explode("-",$urlaub_bearbeiten->start);
            $b_ab = $zw[2].'.'.$zw[1].'.'.$zw[0];
            $zw = explode("-",$urlaub_bearbeiten->end);
            $b_bis = $zw[2].'.'.$zw[1].'.'.$zw[0];
            $b_tage = $urlaub_bearbeiten->amount_days;
            $b_uid = $urlaub_bearbeiten->vid;
            
        }
}

if(isset($_POST['speichern']) && $restu_post >= 0) //wenn ein Urlaubseintrag gespeichert wird
{
     $today = date("d.m.Y");
     $zw1 = explode(".",$_POST['start']);
     $zw2 = explode(".",$_POST['ende']);
                
     if($zw1[0] != '')
     {
         $start = $zw1[2].'-'.$zw1[1].'-'.$zw1[0]; //Datumsformat Startdatum in JJJJ.MM.TT
     }else
     {
         $start = $today;
     }    
                
     if($zw2[0] != '')
     {
         $ende = $zw2[2].'-'.$zw2[1].'-'.$zw2[0]; //Datumsformat Enddatum in JJJJ.MM.TT
     }else
     {
         $ende = $today;
     }

    // print_r($_POST);
     
     if($_POST['uid']==''){
        $anzahl = $_POST['anzahl'];
        $sql_statement = "INSERT INTO employee_vac VALUES(0, '$mid','$start','$ende','$anzahl')";
        mysql_query($sql_statement);    //'INSERT INTO urlaub (uid, mid, ab, bis, tage) VALUES("", "'.$mid.'","'.$start.'","'.$ende.'","'.$anzahl.'")');
     }
     else{
        mysql_query('UPDATE employee_vac SET start="'.$start.'", end="'.$ende.'", amount_days="'.$_POST['anzahl'].'" WHERE vid="'.$_POST['uid'].'"'); 
     }
}
$urlaub_alle_feld = $urlaub->hole_urlaub_durch_mid($mid);
$anzahl_urlaubstage = mysql_fetch_array(mysql_query('SELECT sum(amount_days) FROM employee_vac WHERE eid = "'.$mid.'" GROUP BY eid'));
/* Resturlaub berechnen */
$resturlaub =  $mitarbeiter->max_vac - $anzahl_urlaubstage[0];
//$urlaub_sql = mysql_query('SELECT * FROM urlaub WHERE mid = "'.$mid.'" ORDER by ab');

?>
<form action="index.php?seite=mitarbeiter&sub=urlaub&mid=<?php echo $mitarbeiter->eid; ?>" name="urlaub" method="post">
<?php
if($restu_post < 0)
{
        $restu_post *= -1;
        if($restu_post == 1){
        echo '<table><tr><td colspan="4" class="fehler">Maximale Anzahl Urlaubstage um '.$restu_post.' Tag &uuml;berschritten!</td></tr></table>';
        }
        else{
	echo '<table><tr><td colspan="4" class="fehler">Maximale Anzahl Urlaubstage um '.$restu_post.' Tage &uuml;berschritten!</td></tr></table>';
        }
}
?>
	<table id="top_left">
     	<tr>
          	<td colspan=4><h2>Aktuelle Urlaubsdaten</h2></td>
     	</tr>
     	<tr>
          	<td class="beschriftung">Mitarbeiter</td>
                <td colspan=3 class="beschriftung">Resturlaub (von Gesamturlaub)</td>
          </tr>
     	<tr>
                <td><?php echo $mitarbeiter->last_name; echo ", "; echo $mitarbeiter->first_name; ?></td>
                <td colspan=3>
<?php
                         if($resturlaub < 0)
                         {
                            echo '<span class="rot">'.$resturlaub.'</span>';
                        }
                        else
                        {
                            echo $resturlaub;
                        }
                            echo ' (von '.$mitarbeiter->max_vac.')';
?>
                </td>
                
          	
          </tr>
          <tr>
             	<td colspan=4 class="beschriftung">Urlaubsdaten</td>
     	</tr>
<?php
		/* gespeicherte Urlaubsdaten auflisten */
		foreach($urlaub_alle_feld as $urlaub_alle)
{
          	$zw = explode("-",$urlaub_alle->start);
        		$start = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
       		$zw = explode("-",$urlaub_alle->end);
        		$ende = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Enddatum in TT.MM.JJJJ
               echo '<tr><td colspan=4>'.$start.' - '.$ende.' ('.$urlaub_alle->amount_days.' Arbeitstage)';
                if($_SESSION['mitarbeiter']->role=='1')
			 {
               echo '<br /><a href="index.php?seite=mitarbeiter&sub=urlaub&mid='.$mitarbeiter->eid.'&b='.$urlaub_alle->vid.'" >bearbeiten</a>';
               echo ' | <a href="index.php?seite=mitarbeiter&sub=urlaub&mid='.$mitarbeiter->eid.'&l='.$urlaub_alle->vid.'" onclick="javascript:alert(\'Wollen Sie diese Urlaubsdaten wirklich l&ouml;schen?\');">l&ouml;schen</a></td>';
                         }
}

 if($_SESSION['mitarbeiter']->role=='1')
{
?>
		<tr>
          	<td colspan=4><hr></td>
		</tr>
        </table>
    <table id="top_right">
            <tr>
          	<td><h2>Urlaub bearbeiten</h2></td>
     	</tr>
          <tr>
              <td>Startdatum: </td>
          </tr>
          <tr>
                <td><input class="feld" type="date" size="30" name="start" value="<?php echo $b_ab;  ?>" readonly>
               	<script language="JavaScript">  //Kalender zur Datumsauswahl
        	  			new tcal ({
	                    	'formname': 'urlaub',
	                         'controlname': 'start'
	                  	});
               	</script>
                </td>
          
          </tr>
          <tr>
              <td>Enddatum: </td>
          </tr>
          <tr>
                        
          	  <td><input class="feld" type="date" size="30" name="ende" value="<?php echo $b_bis;  ?>" readonly>
               	<script language="JavaScript">  //Kalender zur Datumsauswahl
        	  			new tcal ({
	                        'formname': 'urlaub',
	                        'controlname': 'ende'
	                  	});
                </script>
               </td>
          
          </tr>
          <tr>
              <td>Anzahl Arbeitstage: </td>
          </tr>
          <tr>
                      
              	<td><input type="hidden" size="5" name="uid" value="<?php if(!empty($b_uid)){ echo $b_uid; }else{ $b_uid = '';} ?>" >
          <input class="feld" type="Text" size="30" name="anzahl" value="<?php echo $b_tage;  ?>" ></td>
                <td style="width: 200px;">&nbsp;</td>
          </tr>
          
          <tr>
               
               <td colspan=4><input class="knopf_speichern" type="submit" name="speichern" value=" "></td>
          </tr>
<?php
}
?>
	</table>
</form>
<?php
}
?>

</div>
