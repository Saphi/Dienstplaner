<?php
 class Schicht_Mitarbeiter
 {
 	public $smid;
 	public $sid;
 	public $mid;
 	public $termin;
 	
 	/* Konstruktor
 	 */
 	public function Schicht_Mitarbeiter()
 	{
 		
 	}
 	
 	/* Schreib Schicht_Mitarbeiter
 	 * �bergabeparameter:	Schichtid
 	 * 						Mitarbeiterid
 	 * 						Termin
 	 */
 	public function schreibe_schicht_mitarbeiter($sid, $mid, $termin)
 	{
 		mysql_query('INSERT INTO empshift VALUES(" ", "'.$mid.'", "'.$termin.'","'.$sid.'", "")');
 	}
 	
 	/* L�scht alle Schicht_Mitarbeiter anhand der Schichtid
 	 * �bergabeparameter:	Schichtid
 	 */
 	public function loesche_alle_schicht_mitarbeiter_durch_sid($sid)
 	{
 		mysql_query("DELETE FROM empshift WHERE shifts_sid='".$sid."'");
 	}
 	
 	/* L�scht alle Schicht_Mitarbeiter anhand der Mitarbeiterid
 	 * �bergabeparameter:	Mitarbeiterid
 	 */
 	public function loesche_alle_schicht_mitarbeiter_durch_mid($mid)
 	{
 		mysql_query("DELETE FROM empshift WHERE employees_eid='".$mid."'");
 	}
 	
 	/* L�scht den Schicht_Mitarbeiter anhand der Schichtid und dem Termin
 	 * �bergabeparameter:	Schichtid
 	 * 						Termin
 	 */
 	public function loesche_schicht_mitarbeiter_durch_sid_termin($sid, $termin)
 	{
 		mysql_query("DELETE FROM empshift WHERE shifts_sid='".$sid."' AND date='".$termin."'");
 	}
        
        public function loesche_schicht_mitarbeiter_durch_smid($smid)
 	{
 		mysql_query("DELETE FROM empshift WHERE empShiftid='".$smid."'");
 	}
 	
 	/* Holt alle Schit_Mitarbeiter anhand der Schichtid
 	 * �bergabeparameter:	Schichtid
 	 * R�ckgabewert:		Feld -> Schicht_mitarbeiter Objekt(e)
 	 */
 	public function hole_alle_schicht_mitarbeiter_durch_sid($sid)
 	{
 		$schichten_mitarbeiter_feld = array();
 		$puffer = mysql_query("SELECT * FROM empshift WHERE shifts_sid='".$sid."'");
 		
 		while($mitarbeiter_schicht_objekt = mysql_fetch_object($puffer, 'Schicht_Mitarbeiter', array('empShiftid', 'shifts_sid', 'employees_eid', 'date')))
 		{
 			$schichten_mitarbeiter_feld[] = $mitarbeiter_schicht_objekt;
 		}
 		return $schichten_mitarbeiter_feld;
 	}
 	
 	/* Holt alle Schit_Mitarbeiter anhand der Schichtid und dem Termin
 	 * �bergabeparameter:	Schichtid
 	 * 						Termin
 	 * R�ckgabewert:		Feld -> Schicht_mitarbeiter Objekt(e)
 	 */
 	public function hole_alle_schicht_mitarbeiter_durch_sid_termin($sid,$termin)
 	{
 		$schichten_mitarbeiter_feld = array();
 		$puffer = mysql_query("SELECT * FROM empshift WHERE shifts_sid='".$sid."' AND date='".$termin."'");
 		
 		while($mitarbeiter_schicht_objekt = mysql_fetch_object($puffer, 'Schicht_Mitarbeiter', array('empShiftid', 'shifts_sid', 'employees_eid', 'date')))
 		{
 			$schichten_mitarbeiter_feld[] = $mitarbeiter_schicht_objekt;
 		}
 		return $schichten_mitarbeiter_feld;
 	}
        
        public function hole_smid_durch_sid_termin_mid($sid,$termin,$mid)
 	{
 		$puffer = mysql_query("SELECT empShiftid FROM empshift WHERE shifts_sid='".$sid."' AND date='".$termin."' AND employees_eid='".$mid."'");
 		return mysql_fetch_array($puffer);
 	}
 	
 	/* Holt den jeweilige schicht_ma Eintrag mit Mitarbeiteranzahl anhand der Schichtid und der Tagesid
 	 * �bergabeparameter:	Schichtid
 	 * 						Tagesid
 	 * R�ckgabewert:		Feld -> schicht_ma Objekt(e) mit Mitarbeiteranzahl
 	 */
 	public function hole_mitarbeiter_anzahl_durch_id($sid, $tid)
 	{
 		$puffer = mysql_query("SELECT must FROM shift_must WHERE sid='".$sid."' AND did='".$tid."'");
 		return mysql_fetch_array($puffer);
 	}
 }
 ?>