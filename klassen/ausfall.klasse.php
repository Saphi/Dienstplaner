<?php
class Ausfall
{
	public $tmid;
	public $mid;
	public $ab;
	public $bis;
	public $explanation;
	
	/* Konstruktor
	 */
	public function Ausfall()
	{
		
	}
	
	/* Holt alle Eintr�ge anhand der �bergebenen Mitarbeiterid
	 * �bergabeparameter:	Mitarbeiterid
	 * R�ckgabewert:		Feld -> Ausfall Objekt(e)
	 */
	public function hole_ausfall_durch_mid($mid)
	{
		$ausfall_feld = array();
		$puffer = mysql_query("SELECT * FROM times_missed_employees WHERE employees_eid='".$mid."' ORDER BY start");
		while($ausfall_objekt = mysql_fetch_object($puffer, 'Ausfall', array('tmid', 'start', 'end', 'explanation', 'empid')))
		{
			$ausfall_feld[] = $ausfall_objekt;
		}
		return $ausfall_feld;
	}
        
        public function hole_ausfall_durch_tmid($tmid)
	{
		$ausfall_feld = array();
		$puffer = mysql_query("SELECT * FROM times_missed_employees WHERE tmid='".$tmid."'");
		while($ausfall_objekt = mysql_fetch_object($puffer, 'Ausfall', array('tmid', 'start', 'end', 'explanation', 'empid')))
		{
			$ausfall_feld[] = $ausfall_objekt;
		}
		return $ausfall_feld;
	}
}
?>