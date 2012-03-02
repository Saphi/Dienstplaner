<div id="hauptinhalt">
<?php
$mid = '';

if(!empty($_POST['mid'])) $mid = $_POST['mid'];
if($mid==''){
    if(!empty($_GET['mid'])) $mid = $_GET['mid'];
}

if($mid==''){
$mid = $_SESSION['mitarbeiter']->eid;
}
/* Daten des ausgew�hlten Mitarbeiters holen */
$mitarbeiter = new Mitarbeiter();
$mitarbeiter_auswahl_feld = $mitarbeiter->hole_alle_mitarbeiter();
?>
<form name="auswahl" action="" method="post">
<select name="mid" onchange="this.form.submit();">
<option value="">- Benutzer auswählen -</option>
<?php
foreach($mitarbeiter_auswahl_feld as $mitarbeiter_auswahl)
{
   
        echo '<option value="'.$mitarbeiter_auswahl->eid.'" ';
        if($mid==$mitarbeiter_auswahl->eid) echo 'selected';
        echo ' >'.$mitarbeiter_auswahl->last_name.', '.$mitarbeiter_auswahl->first_name.'</option>';
   
}
?>
</select>
</form>
<?php

if($mid!='')
{
$mitarbeiter = $mitarbeiter->hole_mitarbeiter_durch_id($mid);
?>

		<form action="index.php?seite=mitarbeiter&sub=bearbeiten&mid=<?php echo $mitarbeiter->eid; ?>" method="post">

            <table id="top_left">
                <tr>
                	<td colspan=2><h2>Person</h2></td>
                </tr>
                <tr>
                    <td class="beschriftung">Name, Vorname</td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php echo $mitarbeiter->last_name.', '.$mitarbeiter->first_name; ?></td>
                    <td></td>
                </tr>
                <tr>
                	
<?php                   
			     	echo '<td class="beschriftung">Rechte</td>';
?>

                </tr>
                <tr>
                        
<?php
			/* nur Administrator, darf Recht, Arbeitsstunden und Urlaub bearbeiten */
                

                                echo '<td>';
                                    
                                    if($mitarbeiter->role==1) echo 'Admin';
                                   
                                    if($mitarbeiter->role==0) echo 'Mitarbeiter';
                                    

                                    echo '<input type="hidden" name="aktiv" value="'.$mitarbeiter->active.'">';
				echo '</td>';

                     
               echo '</tr>';
?>
        </table>
        <table id="top_right">
                <tr>
                	<td colspan=2><h2>Kontaktdaten</h2></td>
                </tr>
                <tr>
                    <td class="beschriftung">Stra&szlig;e, Hausnr.</td>
                    <td class="beschriftung">PLZ, Ort</td>
                </tr>
                <tr>
                    <td><?php echo $mitarbeiter->address; ?></td>
                    <td><?php echo $mitarbeiter->address; ?></td>
                </tr>
		<tr>
                    <td class="beschriftung">E-Mail</td>
                    <td class="beschriftung">Tel.</td>
                </tr>
                <tr>
                    <td><?php echo $mitarbeiter->email; ?></td>
                    <td><?php echo $mitarbeiter->tel; ?></td>
                </tr>


        </table>
        <div id="abschliessen"></div>
<?php           if($_SESSION['mitarbeiter']->role==1 || $_SESSION['mitarbeiter']->eid == $mitarbeiter->eid){?>
        <table id="bottom_left">
                <tr>
                	<td colspan=2><h2>Arbeitsstunden</h2></td>
                </tr>
                <tr>
                    <td class="beschriftung">Tag</td>
                    <td class="beschriftung">Woche</td>
                </tr>
		<tr>
                    <td><?php echo $mitarbeiter->max_h_d; ?></td>
                    <td><?php echo $mitarbeiter->max_h_w; ?></td>
                </tr>

	</table>
        <table id="bottom_right">
                <tr>
                	<td><h2>Urlaubstage</h2></td>
                        <td>
<?php           if($_SESSION['mitarbeiter']->role==1){ ?>
                             <a href="index.php?seite=mitarbeiter&sub=urlaub&mid=<?php echo $mitarbeiter->eid; ?> ">Urlaubsdaten bearbeiten</a>
<?php
}
?>
                        </td>
                </tr>
                <tr>
                    <td class="beschriftung">Urlaubstage pro Jahr</td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php echo $mitarbeiter->max_vac; ?></td>
                    <td></td>
                </tr>
                
           </table>
           <div id="abschliessen"></div>

                    <input class="knopf_bearbeiten" type="submit" name="bearbeiten" value=" ">
                 <?php }
?>
        </form>
<?php
}
?>
	</div>