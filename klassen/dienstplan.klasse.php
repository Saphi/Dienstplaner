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
		$puffer = mysql_query('SELECT termin FROM schicht_mitarbeiter WHERE termin BETWEEN "'.$von.'" AND "'.$bis.'" GROUP BY termin ORDER BY termin');
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
			$dienstplan_objekt_feld[] = $dienstplan_objekt['termin'];
		}
		return $dienstplan_objekt_feld;
	}
        
        public function hole_dienst_durch_termine_mid($termin, $mid)
	{
		$puffer = mysql_query("SELECT sma.termin, s.kbez, s.color FROM schicht_mitarbeiter sma JOIN schicht s ON sma.sid =s.sid WHERE sma.termin = '".$termin."' AND mid = '".$mid."'");
		$dienstplan_objekt = mysql_fetch_object($puffer, 'Dienstplan' , array('termin', 'kbez', 'color'));

		return $dienstplan_objekt;
	}
        
     

 }
 ?>