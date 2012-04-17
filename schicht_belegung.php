<div id="hauptinhalt">
<?php
$sql_s = ("SELECT * FROM shifts");
$query = mysql_query($sql_s);
$sql_t = ("SELECT * FROM days");
$schicht_ma_sql = mysql_query($sql_t);

$s = '';
if(!empty($_GET['s'])) $s = $_GET['s']; 

/* nach Bestätigung aller Angaben */
if($s=='speichern')
{
	/* leeren der Tabellen schicht_ma und tag */
	$leeren = mysql_query("TRUNCATE TABLE shift_must");
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
				$speichern = mysql_query("INSERT INTO shift_must (did, sid, must) VALUES ('".$tid[$i]."', '".$sid."', '".$anzahl."')");
            }
            mysql_data_seek($query, 0); //array zur�cksetzen
        }
	}
        $erfolg='Die Daten wurden aktualisiert.';
	echo '<table><tr><td colspan="2" class="erfolg">'.$erfolg.'</td></tr></table>';
}




/* alle gespeicherten Schichten und Tage holen */
$sql_s = ("SELECT * FROM shifts");
$query = mysql_query($sql_s);
$sql_t = ("SELECT * FROM days");
$schicht_ma_sql = mysql_query($sql_t);


?>
		<form action="index.php?seite=konfig&sub=belegung&s=speichern" method="post">
            <table>
                <tr>
				<th class="kalenderhead">Montag</th>
				<th class="kalenderhead">Dienstag</th>
				<th class="kalenderhead">Mittwoch</th>
				<th class="kalenderhead">Donnerstag</th>
				<th class="kalenderhead">Freitag</th>
				<th class="kalenderhead">Samstag</th>
				<th class="kalenderhead_7">Sonntag</th>
		</tr>
                
                
                <tr>
<?php
        
        while($schicht_ma = mysql_fetch_assoc($schicht_ma_sql))
	{
		$tage[$schicht_ma['did']] = $schicht_ma['name'];
               
	}
       /* while($schichten = mysql_fetch_assoc($query))
            {
                var_dump($schichten);
            }*/
       
	for($i=1; $i<=7; $i++)
   	{
    	$j=1;
        $col_7="";
        if($i==7)$col_7="col_7";
        echo "<td class='kalenderfeld ".$col_7."'>";
        /* f�r jeden ausgew�hlten Wochentag alle gespeicherten Schichten auflisten */
        if(isset($tage[$i]) && $tage[$i]!= "")
        {
			echo "<input type='hidden' name='TID[".$i."]' value='".$i."' >";
            echo "<input type='hidden' name='tag[".$i."]' value='".$tage[$i]."' >";
         
            while($schichten = mysql_fetch_assoc($query))
            {
               
            	$schicht = $schichten["sid"];
				$sql_ma = ("select * from shift_must WHERE sid = ".$schicht." AND did = ".$i);
			    $anzahl_ma_sql = mysql_query($sql_ma);
                $anzahl_ma = mysql_fetch_assoc($anzahl_ma_sql);
                
                echo $schichten['name'].": <br/>";
                echo "<input class='feld' type='Text' size='10' name='MA_".$i."_".$schicht."' ";
                /* bereits gespeicherte Mitarbeiteranzahl angeben */
                if(isset($anzahl_ma))
                {
                	echo "value='".$anzahl_ma['must']."'";
                }
                echo "><br/><br/>";
            }
		
            mysql_data_seek($query, 0);
        }
        echo "</td>";
	}
?>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                   
                    <td colspan="7">
                        <input class="knopf_speichern" type="submit" value=" ">
                    </td>
                </tr>
            </table>
        </form>
<?php

?>
	
    
</div>