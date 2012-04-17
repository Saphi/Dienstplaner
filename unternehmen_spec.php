<div id="submenu">
     <a href="index.php?seite=kalender&sub=uebersicht">zurück zum Kalender</a>
</div>
<div id="hauptinhalt">
<?php
include('inc/config.php');
include('klassen/unternehmen.klasse.php');


$unternehmen = new Unternehmen();

if(isset($_GET['l'])) //wenn ein Urlaubseintrag gelöscht wird
{
	mysql_query('DELETE FROM spec_times_business WHERE sbid = '.$_GET['l'].' LIMIT 1');
}
if(isset($_GET['b'])) //wenn ein Urlaubseintrag bearbeitet wird
{
        
        
	$unternehmen_bearbeiten = $unternehmen->hole_uspec_durch_sbid($_GET['b']);
     
            $zw = explode("-",$unternehmen_bearbeiten->start);
            $b_ab = $zw[2].'.'.$zw[1].'.'.$zw[0];
            $b_expl = $unternehmen_bearbeiten->explanation;
            $b_sbid = $unternehmen_bearbeiten->sbid;
            $b_on = $unternehmen_bearbeiten->open;
            
        
}

if(isset($_POST['speichern'])) //wenn ein Eintrag gespeichert wird
{
     $zw1 = explode(".",$_POST['start']);
     
         $start = $zw1[2].'-'.$zw1[1].'-'.$zw1[0]; //Datumsformat Startdatum in JJJJ.MM.TT
     
    // print_r($_POST);
         
     if($_POST['sbid']==''){
        $unternehmen_termin_neu = new Unternehmen(); 
        $unternehmen_termin_neu->schreibe_uspec($start, $_POST['explanation'], $_POST['open']);
     }
     else{
        $unternehmen_termin_bearbeiten = new Unternehmen(); 
        $unternehmen_termin_bearbeiten->erneuere_uspec($_POST['sbid'], $start, $_POST['explanation'], $_POST['open']);
     }
     
    
}

$unternehmen_on_feld = $unternehmen->hole_on_uspec();
$unternehmen_off_feld = $unternehmen->hole_off_uspec();

?>
<form action="index.php?seite=kalender&sub=uspec" name="uspec" method="post">

	<table id="top_left">
     	<tr>
          	<td colspan=4><h2>Besondere Schlie&szlig;zeiten des Unternehmens</h2></td>
     	</tr>
     	
<?php
		/* gespeicherte Urlaubsdaten auflisten */
		foreach($unternehmen_off_feld as $unternehmen_off)
{
          	$zw = explode("-",$unternehmen_off->start);
        		$start = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
       		
               echo '<tr><td colspan=4>'.$start.' ('.$unternehmen_off->explanation.')';
                if($_SESSION['mitarbeiter']->role=='1')
			 {
               echo '<br /><a href="index.php?seite=kalender&sub=uspec&b='.$unternehmen_off->sbid.'" >bearbeiten</a>';
               echo ' | <a href="index.php?seite=kalender&sub=uspec&l='.$unternehmen_off->sbid.'" onclick="javascript:alert(\'Wollen Sie diesen Eintrag wirklich l&ouml;schen?\');">l&ouml;schen</a></td>';
                         }
}

?>
        <tr>
            <td colspan=4><hr></td>
     	</tr>

     	<tr>
          	<td colspan=4><h2>Besondere &Ouml;ffnungszeiten des Unternehmens</h2></td>
     	</tr>
        <?php
		/* gespeicherte Urlaubsdaten auflisten */
		foreach($unternehmen_on_feld as $unternehmen_on)
{
          	$zw = explode("-",$unternehmen_on->start);
        		$start = $zw[2].'.'.$zw[1].'.'.$zw[0]; //Datumsformat Startdatum in TT.MM.JJJJ
       		
               echo '<tr><td colspan=4>'.$start.' ('.$unternehmen_on->explanation.')';
                if($_SESSION['mitarbeiter']->role=='1')
			 {
               echo '<br /><a href="index.php?seite=kalender&sub=uspec&b='.$unternehmen_on->sbid.'" >bearbeiten</a>';
               echo ' | <a href="index.php?seite=kalender&sub=uspec&l='.$unternehmen_on->sbid.'" onclick="javascript:alert(\'Wollen Sie diesen Eintrag wirklich l&ouml;schen?\');">l&ouml;schen</a></td>';
                         }
}
?>
     	
        </table>
  <?php
    if($_SESSION['mitarbeiter']->role=='1')
{
?>
    <table id="top_right">
            <tr>
          	<td><h2>Sonderzeit hinzufügen</h2></td>
     	</tr>
          <tr>
              <td>Datum: </td>
          </tr>
          <tr>
                <td><input class="feld" type="date" size="30" name="start" value="<?php echo $b_ab;  ?>" readonly>
               	<script language="JavaScript">  //Kalender zur Datumsauswahl
        	  			new tcal ({
	                    	'formname': 'uspec',
	                         'controlname': 'start'
	                  	});
               	</script>
                </td>
          
          </tr>
         
           <tr>
              <td>Beschreibung:</td>
          </tr>
          <tr>             
                        
          	  <td><input class="feld" type="text" size="30" name="explanation" value="<?php echo $b_expl;  ?>" >
               	
               </td>
          
          </tr>
          <tr>
                        
          	  <td><input class="feld" type="radio" name="open" value="1" <?php if($b_on==1) echo "checked"?>>geöffnet
               	
               </td>
          
          </tr>
           <tr>
                        
          	  <td><input class="feld" type="radio" name="open" value="0" <?php if($b_on==0) echo "checked"?>>geschlossen
               	
               </td>
          
          </tr>
          
          <tr>
               
               <td colspan=4><input class="knopf_speichern" type="submit" name="speichern" value=" ">
                   <input type="hidden" size="5" name="sbid" value="<?php if(!empty($b_sbid)){ echo $b_sbid; }else{ $b_sbid = '';} ?>" >
               </td>
          </tr>
<?php
}
?>
	</table>
    
</form>


</div>
