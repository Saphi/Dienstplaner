<div id="hauptinhalt">
<?php
include('inc/config.php');
include('klassen/ausfall.klasse.php');

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
$ausfall = new Ausfall();

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

if(isset($_GET['l'])) //wenn ein Urlaubseintrag gelöscht wird
{
	mysql_query('DELETE FROM times_missed_employees WHERE tmid = '.$_GET['l'].' LIMIT 1');
}
if(isset($_GET['b'])) //wenn ein Urlaubseintrag bearbeitet wird
{
        
        
	$ausfall_bearbeiten_feld = $ausfall->hole_ausfall_durch_tmid($_GET['b']);
        foreach ($ausfall_bearbeiten_feld as $ausfall_bearbeiten) {
            $zw = explode("-",$ausfall_bearbeiten->start);
            $b_ab = $zw[2].'.'.$zw[1].'.'.$zw[0];
            $zw = explode("-",$ausfall_bearbeiten->end);
            $b_bis = $zw[2].'.'.$zw[1].'.'.$zw[0];
            $b_expl = $ausfall_bearbeiten->explanation;
            $b_empid = $ausfall_bearbeiten->mid;
            $b_tmid = $ausfall_bearbeiten->tmid;
            
        }
}

if(isset($_POST['speichern'])) //wenn ein Urlaubseintrag gespeichert wird
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
     
     if($_POST['tmid']==''){
        $explanation = $_POST['explanation'];
        $sql_statement = "INSERT INTO times_missed_employees VALUES(0, '$start','$ende','$explanation','$mid')";
        mysql_query($sql_statement);    //'INSERT INTO urlaub (uid, mid, ab, bis, tage) VALUES("", "'.$mid.'","'.$start.'","'.$ende.'","'.$anzahl.'")');
     }
     else{
        mysql_query('UPDATE times_missed_employees SET start="'.$start.'", end="'.$ende.'", explanation="'.$_POST['explanation'].'" WHERE tmid="'.$_POST['tmid'].'"'); 
     }
}
$ausfall_alle_feld = $ausfall->hole_ausfall_durch_mid($mid);

?>
<form action="index.php?seite=mitarbeiter&sub=ausfall&mid=<?php echo $mitarbeiter->eid; ?>" name="ausfall" method="post">

	<table id="top_left">
     	<tr>
          	<td colspan=4><h2>Aktuelle Ausfalldaten</h2></td>
     	</tr>
     	<tr>
          	<td class="beschriftung">Mitarbeiter: </td>
          </tr>
     	<tr>
                <td><?php echo $mitarbeiter->last_name; echo ", "; echo $mitarbeiter->first_name; ?></td>
                        	
          </tr>
          <tr>
             	<td colspan=4 class="beschriftung">Ausfalldaten</td>
     	</tr>
<?php
		/* gespeicherte Urlaubsdaten auflisten */
		foreach($ausfall_alle_feld as $ausfall_alle)
{
          	$zw = explode("-",$ausfall_alle->start);
        		$start = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
       		$zw = explode("-",$ausfall_alle->end);
        		$ende = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Enddatum in TT.MM.JJJJ
               echo '<tr><td colspan=4>'.$start.' - '.$ende.' ('.$ausfall_alle->explanation.')';
                if($_SESSION['mitarbeiter']->role=='1')
			 {
               echo '<br /><a href="index.php?seite=mitarbeiter&sub=ausfall&mid='.$mitarbeiter->eid.'&b='.$ausfall_alle->tmid.'" >bearbeiten</a>';
               echo ' | <a href="index.php?seite=mitarbeiter&sub=ausfall&mid='.$mitarbeiter->eid.'&l='.$ausfall_alle->tmid.'" onclick="javascript:alert(\'Wollen Sie diese Urlaubsdaten wirklich l&ouml;schen?\');">l&ouml;schen</a></td>';
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
          	<td><h2>Ausfall bearbeiten</h2></td>
     	</tr>
          <tr>
              <td>Startdatum: </td>
          </tr>
          <tr>
                <td><input class="feld" type="date" size="30" name="start" value="<?php echo $b_ab;  ?>" readonly>
               	<script language="JavaScript">  //Kalender zur Datumsauswahl
        	  			new tcal ({
	                    	'formname': 'ausfall',
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
	                        'formname': 'ausfall',
	                        'controlname': 'ende'
	                  	});
                </script>
               </td>
          
          </tr>
          <tr>
              <td>Beschreibung: </td>
          </tr>
          <tr>
                      
              	<td><input type="hidden" size="5" name="tmid" value="<?php if(!empty($b_tmid)){ echo $b_tmid; }else{ $b_tmid = '';} ?>" >
          <input class="feld" type="Text" size="30" name="explanation" value="<?php echo $b_expl;  ?>" ></td>
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
