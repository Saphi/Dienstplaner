<?php
class Mitarbeiter
{
	public $mid;
	public $name;
	public $vname;
	public $adresse;
        public $city;
	public $tel;
	public $email;
	public $max_h_d;
	public $max_h_w;
	public $max_u;
	public $recht;
	public $pw;
	public $aktiv;

	/* Konstruktor
	 */
	public function Mitarbeiter()
	{

	}

	/* Schreib Mitarbeiter in Datenbank
	 * Übergabeparameter:	Name
	 * 						Vorname
	 * 						Adresse
	 * 						Telefon
	 * 						E-Mail UNIQUE
	 * 						Arbeitsstunden Tag
	 * 						Arbeitsstunden Woche
	 *						Arbeitsstunden Monat
	 *						Urlaubstage Jahr
	 *						Recht (0 = Mitarbeiter, 1 = Administrator)
	 *						Passwort (bereits md5 verschl�sselt)
	 *						Aktivstatus (0 = inaktiv, 1 = aktiv -> Standard = 0)
	 */
	public function schreibe_mitarbeiter($name, $vname, $adresse, $city, $tel, $email, $max_h_d, $max_h_w, $max_u, $recht, $pw, $aktiv = '0')
	{

            mysql_query('INSERT INTO employees VALUES("","'.$name.'","'.$vname.'","'.$adresse.'","'.$city.'","'.$tel.'","'.$email.'","'.$max_h_d.'","'.$max_h_w.'","'.$max_u.'","'.$recht.'","'.$pw.'","","'.$aktiv.'")');
	}

	/* Holt den jeweiligen Mitarbeiter anhand der übergebenen Mitarbeiterid
	 * Übergabeparameter:	Mitarbeiterid
	 * Rückgabewert:		Mitarbeiter Objekt
	 */
	public function hole_mitarbeiter_durch_id($mid)
	{
		$puffer = mysql_query('SELECT * FROM employees WHERE eid = '.$mid);
		$mitarbeiter_objekt = mysql_fetch_object($puffer, 'Mitarbeiter' , array('eid', 'last_name', 'first_name', 'address', 'city', 'tel', 'email', 'max_h_d', 'max_h_w', 'max_vac', 'role', 'password', 'department', 'active'));

		return $mitarbeiter_objekt;
	}

	/* Holt den jeweiligen Mitarbeiter anhand der �bergebenen E-Mail
	 * �bergabeparameter:	Mitarbeiter-E-Mail
	 * R�ckgabewert:		Mitarbeiter Objekt
	 */
	public function hole_mitarbeiter_durch_email($email)
	{
		$puffer = mysql_query("SELECT * FROM employees WHERE email='".$email."'");
		$mitarbeiter_objekt = mysql_fetch_object($puffer, 'Mitarbeiter' , array('eid', 'last_name', 'first_name', 'address', 'city', 'tel', 'email', 'max_h_d', 'max_h_w', 'max_vac', 'role', 'password', 'department', 'active'));

		return $mitarbeiter_objekt;
	}

	/* Holt alle Mitarbeiter
	 * R�ckgabewert:	Feld -> Mitarbeiter Objekt(e)
	 */
	public function hole_alle_mitarbeiter()
	{
		$mitarbeiter_objekt_feld = array();
		$puffer = mysql_query('SELECT * FROM employees');
		while($mitarbeiter_objekt = mysql_fetch_object($puffer, 'Mitarbeiter' , array('eid', 'last_name', 'first_name', 'address', 'city', 'tel', 'email', 'max_h_d', 'max_h_w', 'max_vac', 'role', 'password', 'department', 'active')))
		{
			$mitarbeiter_objekt_feld[] = $mitarbeiter_objekt;
		}
		return $mitarbeiter_objekt_feld;
	}

	/* Erneuert den bereits vorhandenen Mitarbeiter anhand der �bergebenen Mitarbeiterid
	 * �bergabeparameter:	Mitarbeiterid
	 * 						Name
	 * 						Vorname
	 * 						Adresse
	 * 						Telefon
	 * 						E-Mail UNIQUE
	 * 						Arbeitsstunden Tag
	 * 						Arbeitsstunden Woche
	 *						Arbeitsstunden Monat
	 *						Urlaubstage Jahr
	 *						Recht (0 = Mitarbeiter, 1 = Administrator)
	 *						Passwort (bereits md5 verschl�sselt)
	 *						Aktivstatus (0 = inaktiv, 1 = aktiv -> Standard = 0)
	 */
	public function erneuere_mitarbeiter($mid, $name, $vname, $adresse, $city, $tel, $email, $max_h_d, $max_h_w, $max_u, $recht, $pw, $aktiv)
	{
		mysql_query("UPDATE employees SET last_name='".$name."', first_name='".$vname."', address='".$adresse."', city='".$city."', tel='".$tel."', email='".$email."', max_h_d='".$max_h_d."', max_h_w='".$max_h_w."', max_vac='".$max_u."', role='".$recht."', password='".$pw."', active='".$aktiv."' WHERE eid='".$mid."'");
	}

	/* L�scht den Mitarbeiter anhand der �bergebenen Mitarbeiterid
	 * �bergabewert:	Mitarbeiterid
	 */
	public function loesche_mitarbeiter_durch_id($mid)
	{
		mysql_query("DELETE FROM employees WHERE eid='".$mid."'");
	}

	/* Aktiviert/Deaktiviert den Mitarbeiter anhand der �bergebenen Mitarbeiterid und des Aktivstatus
	 * �bergabeparameter:	Mitarbeiterid
	 * 						Aktivstatus
	 */
	public function aktiviere_mitarbeiter_durch_id($mid, $aktiv)
	{
		mysql_query("UPDATE employees SET active=".$aktiv." WHERE eid='".$mid."'");
	}

	/* Testet die �bergebene E-Mail, ob sie bereits in der Datenbank vorhanden ist
	 * �bergabeparameter: E-Mail
	 * R�ckgabewert:	True (E-Mail bereits vorhanden)
	 * 					False (E-Mail noch nicht vorhanden)
	 */
	public function teste_email($email)
	{
		$puffer = mysql_query("SELECT * FROM employees WHERE email='".$email."'");
		if(mysql_fetch_row($puffer))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>