<div id="hauptinhalt">
<?php
$sql_s = ("SELECT * FROM schicht");
$query = mysql_query($sql_s);
/* nach Best�tigung aller Angaben */
if($_GET['s']=='speichern')
{
	/* leeren der Tabellen schicht_ma und tag */
	$leeren = mysql_query("TRUNCATE TABLE schicht_ma");
	$tag = $_POST["tag"];
	$tid = $_POST["TID"];
    for($i=1; $i<=7; $i++)
	{
		if(isset($tag[$i]) && $tag[$i]!= "")
                {
        		/* speichern der Angaben */
			
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




/* alle gespeicherten Schichten und Tage holen */
$sql_s = ("SELECT * FROM schicht");
$query = mysql_query($sql_s);
$sql_t = ("SELECT * FROM tag");
$schicht_ma_sql = mysql_query($sql_t);


?>
		<form action="index.php?seite=konfig&sub=belegung&s=speichern" method="post">
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
        
        while($schicht_ma = mysql_fetch_assoc($schicht_ma_sql))
	{
		$tage[$schicht_ma['tid']] = $schicht_ma['name'];
               
	}
       /* while($schichten = mysql_fetch_assoc($query))
            {
                var_dump($schichten);
            }*/
       
	for($i=1; $i<=7; $i++)
   	{
    	$j=1;
        
        /* f�r jeden ausgew�hlten Wochentag alle gespeicherten Schichten auflisten */
        if(isset($tage[$i]) && $tage[$i]!= "")
        {
			echo "<input type='hidden' name='TID[".$i."]' value='".$i."' >";
            echo "<input type='hidden' name='tag[".$i."]' value='".$tage[$i]."' >";
         	echo "<td><b>".$tage[$i].":</b> </td>";
            while($schichten = mysql_fetch_assoc($query))
            {
               
            	$schicht = $schichten["sid"];
				$sql_ma = ("select * from schicht_ma WHERE sid = ".$schicht." AND tid = ".$i);
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
                        <input class="knopf_speichern" type="submit" value=" ">
                    </td>
                </tr>
            </table>
        </form>
<?php

?>
	
    
</div>