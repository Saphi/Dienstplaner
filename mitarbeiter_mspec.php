<div id="hauptinhalt">
<?php
include('inc/config.php');
include('klassen/ma_sonderzeiten.klasse.php');
include('klassen/schicht.klasse.php');

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
$sonderzeit = new Sonderzeit();
$schicht = new Schicht();

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
	mysql_query('DELETE FROM spec_times_employees WHERE smid = '.$_GET['l'].' LIMIT 1');
}


if(isset($_POST['speichern'])) //wenn ein Urlaubseintrag gespeichert wird
{
     

    // print_r($_POST);
        $sql_statement = "INSERT INTO spec_times_employees VALUES(0, '$mitarbeiter->eid','0','$_POST[shift]')";
        mysql_query($sql_statement);    //'INSERT INTO urlaub (uid, mid, ab, bis, tage) VALUES("", "'.$mid.'","'.$start.'","'.$ende.'","'.$anzahl.'")');

}
$sonderzeit_alle_feld = $sonderzeit->hole_sonderzeit_durch_mid($mid);

?>
<form action="index.php?seite=mitarbeiter&sub=mspec&mid=<?php echo $mitarbeiter->eid; ?>" name="sonderzeit" method="post">

	<table id="top_left">
     	<tr>
          	<td colspan=4><h2>Aktuelle Sonderzeiten</h2></td>
     	</tr>
     	<tr>
          	<td class="beschriftung">Mitarbeiter: </td>
          </tr>
     	<tr>
                <td><?php echo $mitarbeiter->last_name; echo ", "; echo $mitarbeiter->first_name; ?></td>
                        	
          </tr>
          <tr>
             	<td colspan=4 class="beschriftung">Ausgeschlossene Schichten</td>
     	</tr>
<?php
		/* gespeicherte Urlaubsdaten auflisten */
		foreach($sonderzeit_alle_feld as $sonderzeit_alle)
{
          	
                $schicht_name = $schicht->hole_schicht_durch_id($sonderzeit_alle->shifts_sid);
                
                    
               echo '<tr><td colspan=4>'.$schicht_name->name.' ';
                
                if($_SESSION['mitarbeiter']->role=='1')
			 {
               echo '<a href="index.php?seite=mitarbeiter&sub=mspec&mid='.$mitarbeiter->eid.'&l='.$sonderzeit_alle->smid.'" onclick="javascript:alert(\'Wollen Sie diesen Eintrag wirklich l&ouml;schen?\');">l&ouml;schen</a></td>';
                         }
}

 if($_SESSION['mitarbeiter']->role=='1')
{
     
     $schichten_alle = $schicht->hole_alle_schichten();
?>
		<tr>
          	<td colspan=4><hr></td>
		</tr>
        </table>
    <table id="top_right">
            <tr>
          	<td><h2>Sonderzeiten bearbeiten</h2></td>
     	</tr>
          <tr>
              <td>Schicht: </td>
          </tr>
          <tr>
                <td><select name="shift" >
<option value="">- Schicht ausw&auml;hlen -</option>
<?php
foreach($schichten_alle as $schicht_auswahl)
{
      
        echo '<option value="'.$schicht_auswahl->sid.'" ';
        if($sid==$schicht_auswahl->sid) echo 'selected';
        echo ' >'.$schicht_auswahl->name.' ('.$schicht_auswahl->nick.')</option>';
       
}
?>
</select>
                </td>
          
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
