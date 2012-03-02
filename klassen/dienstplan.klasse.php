<?php
 class Dienstplan
 {
 	public $smid;
 	public $sid;
 	public $mid;
 	public $termin;
 	
 	/* Konstruktor
 	 */
 	public function Dienstplan()
 	{
 		
 	}
 	
        public function hole_alle_termine_von_bis($von, $bis)
	{
		$dienstplan_objekt_feld = array();
		$puffer = mysql_query('SELECT date FROM empshift WHERE date BETWEEN "'.$von.'" AND "'.$bis.'" GROUP BY date ORDER BY date');
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
			$dienstplan_objekt_feld[] = $dienstplan_objekt['date'];
		}
		return $dienstplan_objekt_feld;
	}
        
        public function hole_dienst_durch_termine_mid($termin, $mid)
	{
		$puffer = mysql_query("SELECT sma.date, s.nick, s.color FROM empshift sma JOIN shifts s ON sma.shifts_sid =s.sid WHERE sma.date = '".$termin."' AND sma.employees_eid = '".$mid."'");
		$dienstplan_objekt = mysql_fetch_object($puffer, 'Dienstplan' , array('date', 'nick', 'color'));

		return $dienstplan_objekt;
	}
        
     

 }
 ?>