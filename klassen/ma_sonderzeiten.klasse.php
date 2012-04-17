<?php
class Sonderzeit
{
	public $smid;
	public $mid;
	public $shift;
	public $day;
	
	/* Konstruktor
	 */
	public function Sonderzeit()
	{
		
	}
	
	/* Holt alle Eintr�ge anhand der �bergebenen Mitarbeiterid
	 * �bergabeparameter:	Mitarbeiterid
	 * R�ckgabewert:		Feld -> Ausfall Objekt(e)
	 */
	public function hole_sonderzeit_durch_mid($mid)
	{
		$sonderzeit_feld = array();
		$puffer = mysql_query("SELECT * FROM spec_times_employees WHERE employees_eid='".$mid."' ORDER BY days_did");
		while($sonderzeit_objekt = mysql_fetch_object($puffer, 'Sonderzeit', array('smid', 'empid', 'day', 'shift')))
		{
			$sonderzeit_feld[] = $sonderzeit_objekt;
		}
		return $sonderzeit_feld;
	}
        
}
?>