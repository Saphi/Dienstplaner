<?php
$wochentage = array("Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag");

/* alle gespeicherten Schichten und Tage holen */
$sql_s = ("SELECT * FROM shifts");
$query = mysql_query($sql_s);
$sql_t = ("SELECT * FROM days");
$schicht_ma_sql = mysql_query($sql_t);

if($_GET['s']==1)
{
	while($schicht_ma = mysql_fetch_assoc($schicht_ma_sql))
	{
		$tag[] = $schicht_ma['name'];
	}
?>
		<form action="index.php?seite=tage&s=2" method="post">
            <table>
                <tr>
                	<td colspan=2><h2>relevante Wochentage</h2></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="beschriftung">Wochentage ausw&auml;hlen:</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>
<?php
	$i=1;
     /* alle Wochetage auflisten und bereits gespeicherte ausw�hlen */
	foreach($wochentage as $wtag)
	{
		echo '<input type="checkbox" name="tage['.$i.']" value="'.$wtag.'"';

		if(isset($tag))
		{
			if(in_array($wtag, $tag))
			{
				echo "checked";
			}
		}
		echo ' >'.$wtag.'<br>';
	    $i++;
	}
?>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    	<input class="knopf" type="submit" value="weiter">
                    </td>
                </tr>
            </table>
        </form>
<?php
}
/* nach Auswahl der Wochentage, "weiter" */
if($_GET['s']==2)
{
?>
		<form action="index.php?seite=tage&s=speichern" method="post">
            <table>
                <tr>
                	<td colspan=2><h2>ben&ouml;tigte Mitarbeiter</h2></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td  class="beschriftung">Mitarbeiteranzahl angeben:</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
<?php
	for($i=1; $i<=7; $i++)
   	{
    	$j=1;
        $tage = $_POST['tage'];
        /* f�r jeden ausgew�hlten Wochentag alle gespeicherten Schichten auflisten */
        if(isset($tage[$i]) && $tage[$i]!= "")
        {
			echo "<input type='hidden' name='TID[".$i."]' value='".$i."' >";
            echo "<input type='hidden' name='tag[".$i."]' value='".$tage[$i]."' >";
         	echo "<td><b>".$tage[$i].":</b> </td>";
            while($schichten = mysql_fetch_assoc($query))
            {
            	$schicht = $schichten["sid"];
				$sql_ma = ("select * from shift_must WHERE sid = ".$schicht." AND did = ".$i);
			    $anzahl_ma_sql = mysql_query($sql_ma);
                $anzahl_ma = mysql_fetch_assoc($anzahl_ma_sql);
                echo "<td>";
                echo $schichten['bez']." (".$schichten['ab']." - ".$schichten['bis']."): </td>";
                echo "<td><input class='feld_klein' type='Text' size='5' name='MA_".$i."_".$schicht."' ";
                /* bereits gespeicherte Mitarbeiteranzahl angeben */
                if(isset($anzahl_ma))
                {
                	echo "value='".$anzahl_ma['ma']."'";
                }
                echo "></td></tr><tr><td></td>";
			}
			echo "</tr><tr><td colspan=3><br></td></tr>  ";
            mysql_data_seek($query, 0);
        }
	}
?>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input class="knopf" type="submit" value="Best&auml;tigen">
                    </td>
                </tr>
            </table>
        </form>
<?php
}
/* nach Best�tigung aller Angaben */
if($_GET['s']=='speichern')
{
	/* leeren der Tabellen schicht_ma und tag */
	$leeren = mysql_query("TRUNCATE TABLE schicht_ma");
    $leeren = mysql_query("TRUNCATE TABLE tag");
	$tag = $_POST["tag"];
	$tid = $_POST["TID"];
    for($i=1; $i<=7; $i++)
	{
		if(isset($tag[$i]) && $tag[$i]!= "")
        {
        		/* speichern der Angaben */
			$speichern = mysql_query("INSERT INTO tag (TID, name) VALUES ('".$tid[$i]."', '".$tag[$i]."')");
			while($schichten = mysql_fetch_assoc($query))
			{
            	$sid = $schichten["sid"];
				$id = "MA_".$i."_".$sid;
                $anzahl = $_POST[$id];
				$speichern = mysql_query("INSERT INTO schicht_ma (TID, SID, MA)	VALUES ('".$tid[$i]."', '".$sid."', '".$anzahl."')");
            }
            mysql_data_seek($query, 0); //array zur�cksetzen
        }
	}
    echo "Daten aktualisiert.";
}
?>
	</div>
	<br id="abschliessen">
</div>
<div id="fuss">
    <div id="fuss_text">
        Hier k&ouml;nnen f�r jeden Arbeitstag zu den erstellten Schichten<br>
         die ben�tigte Anzahl an Mitarbeitern angegeben werden.
    </div>
</div>