<div id="hauptinhalt">
<?php

$sid = '';

<<<<<<< HEAD
if(!empty($_POST['sid'])) $sid = $_POST['sid'];
=======
    $sid = $_POST['sid'];

if($sid==''){
    $sid = $_GET['sid'];
}
>>>>>>> upstream/project

if($sid==''){
    if(!empty($_GET['sid'])) $sid = $_GET['sid'];
}

/* Daten der ausgewählten Schicht holen */
$schicht_neu = new Schicht();

/* pr�fen der Eingaben auf Fehler */
function testen()
{
	$fehler = array();
	if(strlen($_POST['bez'])=='0')
	{
		$fehler['bez'] = 'Bitte geben Sie eine Bezeichnung ein!';
	}
	if(strlen($_POST['kbez'])=='0')
	{
		$fehler['kbez'] = 'Bitte geben Sie eine Kurzbezeichnung ein!';
	}
	if(strlen($_POST['ab'])=='0')
	{
		$fehler['ab'] = 'Bitte geben Sie die Startzeit der Schicht ein!';
	}
	if(strlen($_POST['bis'])=='0')
	{
		$fehler['bis'] = 'Bitte geben Sie die Endzeit der Schicht ein!';
	}
        if(!strpos($_POST['ab'] , ":" ) && !isset($fehler['ab']))
	{
		$fehler['ab'] = 'Bitte geben Sie die Startzeit im Format HH:MM an!';
	}
        if(!strpos($_POST['bis'] , ":" ) && !isset($fehler['bis']))
	{
		$fehler['bis'] = 'Bitte geben Sie die Endzeit im Format HH:MM an!';
	}
	return $fehler;
}

/* nach Best�tigung der Angaben */

if(isset($_POST['speichern']))
{
	$fehler = testen();
     /* wenn kein Fehler gefunden wurde, speichern der Angaben */
	if(count($fehler)=='0')
	{
		$schicht_neu->erneuere_schicht($sid, $_POST['bez'], $_POST['kbez'], $_POST['ab'], $_POST['bis'], $_POST['color']);
		$erfolg = 'Schicht erfolgreich aktualisiert.';
	}
}

#$schicht = $schicht_neu->hole_schicht_durch_id($sid);
$schicht = $schicht_neu->hole_alle_schichten();
$schichtfarben = $schicht_neu->hole_alle_schichtfarben();

?>
<form name="auswahl" action="" method="post">
<select name="sid" onchange="this.form.submit();">
<option value="">- Schicht ausw&auml;hlen -</option>
<?php
foreach($schicht as $schicht_auswahl)
{
        echo '<option value="'.$schicht_auswahl->sid.'" ';
        if($sid==$schicht_auswahl->sid) echo 'selected';
        echo ' >'.$schicht_auswahl->name.' ('.$schicht_auswahl->nick.')</option>';
}
?>
</select>
</form>
<?php

if($sid!='')
{
$schicht = $schicht_neu->hole_schicht_durch_id($sid);

if(isset($_GET['c'])){
    $color=$_GET['c'];
}
else{
    $color=$schicht->color;
}


$schicht = $schicht_neu->hole_schicht_durch_id($sid);
?>
		<form action="index.php?seite=konfig&sub=bearbeiten&sid=<?php echo $sid; ?>" method="post">
            <table>
                <tr>
                	<td><h2>Schicht bearbeiten</h2></td>
                </tr>
<?php
if(isset($erfolg))
{
	echo '<tr><td colspan="2" class="erfolg">'.$erfolg.'</td></tr>';
}
else
{
	/* wenn Fehler gefunden wurde, Ausgabe der Fehlermeldung */
	if(isset($fehler) && count($fehler)>'0')
	{
		echo '<tr><td colspan="2" class="fehler">';
		foreach($fehler as $einzelfehler)
		{
			echo $einzelfehler.'<br>';
		}
		echo '</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
	}
}
?>
            </table>
             <table id="top_left" style="border:none;">
		        
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['bez'])) echo 'style="color:red;"'; ?>>Bezeichnung</td>
                    <td class="beschriftung"<?php if(isset($fehler['kbez'])) echo 'style="color:red;"'; ?>>Kurzbezeichnung</td>
                </tr>
                <tr>
                    <td><input class="feld" type="Text" size="26" name="bez" value="<?php if(isset($_POST['bez'])) echo $_POST['bez']; else echo $schicht->name; ?>"></td>
                    <td><input class="feld" type="Text" size="26" name="kbez" value="<?php if(isset($_POST['kbez'])) echo $_POST['kbez']; else echo $schicht->nick; ?>"></td>
                </tr>
                <tr>
                    <td class="beschriftung"<?php if(isset($fehler['ab'])) echo 'style="color:red;"'; ?>>Startzeit</td>
                    <td class="beschriftung"<?php if(isset($fehler['bis'])) echo 'style="color:red;"'; ?>>Endzeit</td>
                </tr>
                <tr>
                    
                    <td><input class="feld" type="Text" size="26" name="ab" value="<?php if(isset($_POST['ab'])) echo $_POST['ab']; else echo $schicht->start; ?>"></td>
                    <td><input class="feld" type="Text" size="26" name="bis" value="<?php if(isset($_POST['bis'])) echo $_POST['bis']; else echo $schicht->end; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="knopf_speichern" name="speichern" type="submit" value=" "></td>
                </tr>
            </table>
           
            <table id="top_right" >
                <tr>
                    <td class="beschriftung" colspan="2">Farbe</td>
                </tr>
                <tr>
                    <td>   
                        <input name="color" type="hidden" id="farbewert" value="<?php echo $color; ?>">
                        <div class="farbquad" id="farbeanz" style="background-color:#<?php echo $color; ?>"></div>
                    </td>
                    <td><span class="farbwahl" >Farbe w&auml;hlen
                        
                        <div id="farbauswahlfeld">
                          <?php
                               
                                
                                foreach($alle_farben as $farbe){
                                    if(in_array($farbe, $schichtfarben)){
                                        echo '<div class="farbquad" style="background-color:#fff"></div>';
                                    }
                                    else{
                                        ?>
                                        <div class="farbquad" style="background-color:#<?php echo $farbe;?>">
                                            <a href="javascript:Changecolor('<?php echo $farbe;?>')"> </a>
                                        </div>
                                   <?php
                                    }
                                }        
                         ?>               
                                                      
                        </div>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><a href="index.php?seite=konfig&sub=belegung">Belegung bearbeiten</a></td>
                </tr>
            </table>

        </form>
	
   

 <?php
}
?>
</div>
