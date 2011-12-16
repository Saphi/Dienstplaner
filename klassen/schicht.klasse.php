<?php
include ('klassen/schicht_mitarbeiter.klasse.php');

class Schicht
{
	public $sid;
	public $bez;
	public $kbez;
	public $ab;
	public $bis;
	
	/* Konstruktor
	 */
	public function Schicht()
	{
		
	}
	
	/* Holt die jeweilige Schicht anhand der Schichtid
	 * �bergabeparameter:	Schichtid
	 * R�ckgabewert:		Feld -> Schicht Objekt(e)
	 */
	public function hole_schicht_durch_id($sid)
	{
		$puffer = mysql_query('SELECT * FROM schicht where sid ='.$sid);
		$schicht_objekt = mysql_fetch_object($puffer, 'Schicht', array('sid', 'bez', 'kbez', 'ab', 'bis'));
		
		return $schicht_objekt;
	}
	
	/* Holt alle Schichten sortiert nach ab und bis
	 * R�ckgabewert:		Feld -> Schicht Objekt(e)
	 */
	public function hole_alle_schichten()
	{
		$schichten_objekt_feld = array();
		$puffer = mysql_query('SELECT * FROM schicht ORDER BY ab, bis ASC');
		
		while($schicht_objekt = mysql_fetch_object($puffer, 'Schicht' , array('sid', 'bez', 'kbez', 'ab', 'bis')))
		{
			$schichten_objekt_feld[] = $schicht_objekt;
		}
		return $schichten_objekt_feld;
	}
	
	/* Holt alle Schichten deren Schicht_Mitarbeiter und die ben�tigte Mitarbeiteranzahl
	 * R�ckgabewert:		Feld -> Schicht Objekt(e)
	 * 								Schicht_Mitarbeiter
	 * 								ben�tigte Mitarbeiteranzahl
	 */
	public function hole_alle_schichten_fuer_kalender()
	{
		$schicht_mitarbeiter_kalender_feld = array();
		$puffer = mysql_query('SELECT * FROM schicht_ma');
		while($schicht_mitarbeiter_kalender_reihe = mysql_fetch_row($puffer))
		{
			$schicht = new Schicht();
			$schicht = $schicht->hole_schicht_durch_id($schicht_mitarbeiter_kalender_reihe['1']);
			$schicht_mitarbeiter = new Schicht_Mitarbeiter();
			$schicht_mitarbeiter_feld = array();
			$schicht_mitarbeiter_feld = $schicht_mitarbeiter->hole_alle_schicht_mitarbeiter_durch_sid($schicht_mitarbeiter_kalender_reihe['1']);
			$schicht_mitarbeiter_kalender_feld[$schicht_mitarbeiter_kalender_reihe['0']][] = $schicht;
			$schicht_mitarbeiter_kalender_feld[$schicht_mitarbeiter_kalender_reihe['0']][] = $schicht_mitarbeiter_feld;
			$schicht_mitarbeiter_kalender_feld[$schicht_mitarbeiter_kalender_reihe['0']][][] = $schicht_mitarbeiter_kalender_reihe;
		}
		return $schicht_mitarbeiter_kalender_feld;
	}

	/* Schreibt Schicht in datenbank
	 * �bergabeparameter:	Bezeichnung
	 * 						Kurzbezeichnung
	 * 						Schichtstartzeit
	 * 						Schichtendzeit
	 */
	public function schreibe_schicht($bez, $kbez, $ab, $bis)
	{
		mysql_query('INSERT INTO schicht VALUES(" ", "'.$bez.'", "'.$kbez.'", "'.$ab.'", "'.$bis.'")');
	}
	
	/* Erneuert die bereits vorhandene Schicht
	 * �bergabeparameter:	Schichtid
	 * 						Bezeichnung
	 * 						Kurzbezeichnung
	 * 						Schichtstartzeit
	 * 						Schichtendzeit
	 */
	public function erneuere_schicht($sid, $bez, $kbez, $ab, $bis)
	{
		mysql_query("UPDATE schicht SET bez='".$bez."', kbez='".$kbez."', ab='".$ab."', bis='".$bis."' WHERE sid='".$sid."'");
	}
	
	/* L�scht Schicht anhand der �bergebenen Schichtid
	 * �bergabeparameter:	Schichtid
	 */
	public function loesche_schicht_durch_id($sid)
	{
		mysql_query("DELETE FROM schicht WHERE sid='".$sid."'");
	}
}
?>