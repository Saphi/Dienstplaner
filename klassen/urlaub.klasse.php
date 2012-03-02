<?php
class Urlaub
{
	public $uid;
	public $mid;
	public $ab;
	public $bis;
	public $tage;
	
	/* Konstruktor
	 */
	public function Urlaub()
	{
		
	}
	
	/* Holt alle Urlaubseintr�ge anhand der �bergebenen Mitarbeiterid
	 * �bergabeparameter:	Mitarbeiterid
	 * R�ckgabewert:		Feld -> Urlaub Objekt(e)
	 */
	public function hole_urlaub_durch_mid($mid)
	{
		$urlaub_feld = array();
		$puffer = mysql_query("SELECT * FROM employee_vac WHERE eid='".$mid."' ORDER BY start");
		while($urlaub_objekt = mysql_fetch_object($puffer, 'Urlaub', array('vid', 'eid', 'start', 'end', 'amount_days')))
		{
			$urlaub_feld[] = $urlaub_objekt;
		}
		return $urlaub_feld;
	}
        
        public function hole_urlaub_durch_uid($uid)
	{
		$urlaub_feld = array();
		$puffer = mysql_query("SELECT * FROM employee_vac WHERE vid='".$uid."'");
		while($urlaub_objekt = mysql_fetch_object($puffer, 'Urlaub', array('vid', 'eid', 'start', 'end', 'amount_days')))
		{
			$urlaub_feld[] = $urlaub_objekt;
		}
		return $urlaub_feld;
	}
}
?>