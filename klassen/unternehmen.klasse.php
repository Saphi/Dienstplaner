<?php
class Unternehmen
{
	public $sbid;
	public $start;
        public $explanation;
	public $open;

	/* Konstruktor
	 */
	public function Unternehmen()
	{

	}

	/* Schreib Mitarbeiter in Datenbank
	 * Übergabeparameter:	Startdatum
	 * 			Enddatum
	 * 			Beschreibung
	 * 			On
	 */
	public function schreibe_uspec($start, $explanation, $open)
	{

            mysql_query('INSERT INTO spec_times_business VALUES("","'.$start.'","'.$explanation.'","'.$open.'")');
	}

	/* Holt alle Daten zu besonderen Öffungszeiten des Unternehmens
	 * Rückgabewert:		Unternehmen Objekt
	 */
	public function hole_on_uspec()
	{
		$unternehmen_objekt_feld = array();
		$puffer = mysql_query('SELECT * FROM spec_times_business WHERE open = 1');
                
		while($unternehmen_objekt = mysql_fetch_object($puffer, 'Unternehmen' , array('sbid','start', 'explanation', 'open')))
		{
			$unternehmen_objekt_feld[] = $unternehmen_objekt;
		}
                
		return $unternehmen_objekt_feld;
	}
        
        /* Holt alle Daten zu besonderen Schließzeiten des Unternehmens
	 * Rückgabewert:		Unternehmen Objekt
	 */
	public function hole_off_uspec()
	{
		$unternehmen_objekt_feld = array();
		$puffer = mysql_query('SELECT * FROM spec_times_business WHERE open = 0');
		while($unternehmen_objekt = mysql_fetch_object($puffer, 'Unternehmen' , array('sbid','start', 'explanation', 'open')))
		{
			$unternehmen_objekt_feld[] = $unternehmen_objekt;
		}
		return $unternehmen_objekt_feld;
	}
        
        public function hole_uspec_durch_sbid($sbid)
	{
		$puffer = mysql_query("SELECT * FROM spec_times_business WHERE sbid='".$sbid."'");
		$unternehmen_objekt = mysql_fetch_object($puffer, 'Unternehmen' , array('sbid','start', 'explanation', 'open'));

		return $unternehmen_objekt;
	}

	
	/* Erneuert den bereits vorhandenen Eintrag

	 */
	public function erneuere_uspec($sbid, $start, $explanation, $open)
	{
		mysql_query("UPDATE spec_times_business SET start='".$start."', explanation='".$explanation."', open='".$open."' WHERE sbid='".$sbid."'");
	}

	
}
?>