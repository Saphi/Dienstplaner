<?php
class Mitarbeiter
{
	public $mid;
	public $name;
	public $vname;
	public $adresse;
	public $tel;
	public $email;
	public $max_h_d;
	public $max_h_w;
	public $max_h_m;
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
	 * �bergabeparameter:	Name
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
	public function schreibe_mitarbeiter($name, $vname, $adresse, $tel, $email, $max_h_d, $max_h_w, $max_h_m, $max_u, $recht, $pw, $aktiv = '0')
	{
		mysql_query('INSERT INTO mitarbeiter VALUES("","'.$name.'","'.$vname.'","'.$adresse.'","'.$tel.'","'.$email.'","'.$max_h_d.'","'.$max_h_w.'","'.$max_h_m.'","'.$max_u.'","'.$recht.'","","'.$pw.'","'.$aktiv.'")');
	}

	/* Holt den jeweiligen Mitarbeiter anhand der �bergebenen Mitarbeiterid
	 * �bergabeparameter:	Mitarbeiterid
	 * R�ckgabewert:		Mitarbeiter Objekt
	 */
	public function hole_mitarbeiter_durch_id($mid)
	{
		$puffer = mysql_query('SELECT * FROM mitarbeiter WHERE mid = '.$mid);
		$mitarbeiter_objekt = mysql_fetch_object($puffer, 'Mitarbeiter' , array('mid', 'name', 'vname', 'adresse', 'tel', 'email', 'max_h_d', 'max_h_w', 'max_h_m', 'max_u', 'recht', 'pw', 'aktiv'));

		return $mitarbeiter_objekt;
	}

	/* Holt den jeweiligen Mitarbeiter anhand der �bergebenen E-Mail
	 * �bergabeparameter:	Mitarbeiter-E-Mail
	 * R�ckgabewert:		Mitarbeiter Objekt
	 */
	public function hole_mitarbeiter_durch_email($email)
	{
		$puffer = mysql_query("SELECT * FROM mitarbeiter WHERE email='".$email."'");
		$mitarbeiter_objekt = mysql_fetch_object($puffer, 'Mitarbeiter' , array('mid', 'name', 'vname', 'adresse', 'tel', 'email', 'max_h_d', 'max_h_w', 'max_h_m', 'max_u', 'recht', 'pw', 'aktiv'));

		return $mitarbeiter_objekt;
	}

	/* Holt alle Mitarbeiter
	 * R�ckgabewert:	Feld -> Mitarbeiter Objekt(e)
	 */
	public function hole_alle_mitarbeiter()
	{
		$mitarbeiter_objekt_feld = array();
		$puffer = mysql_query('SELECT * FROM mitarbeiter');
		while($mitarbeiter_objekt = mysql_fetch_object($puffer, 'Mitarbeiter' , array('mid', 'name', 'vname', 'adresse', 'tel', 'email', 'max_h_d', 'max_h_w', 'max_h_m', 'max_u', 'recht', 'pw', 'aktiv')))
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
	public function erneuere_mitarbeiter($mid, $name, $vname, $adresse, $tel, $email, $max_h_d, $max_h_w, $max_h_m, $max_u, $recht, $pw, $aktiv = '0')
	{
		mysql_query("UPDATE mitarbeiter SET name='".$name."', vname='".$vname."', adresse='".$adresse."', tel='".$tel."', email='".$email."', max_h_d='".$max_h_d."', max_h_w='".$max_h_w."', max_h_m='".$max_h_m."', max_u='".$max_u."', recht='".$recht."', pw='".$pw."', aktiv='".$aktiv."' WHERE mid='".$mid."'");
	}

	/* L�scht den Mitarbeiter anhand der �bergebenen Mitarbeiterid
	 * �bergabewert:	Mitarbeiterid
	 */
	public function loesche_mitarbeiter_durch_id($mid)
	{
		mysql_query("DELETE FROM mitarbeiter WHERE mid='".$mid."'");
	}

	/* Aktiviert/Deaktiviert den Mitarbeiter anhand der �bergebenen Mitarbeiterid und des Aktivstatus
	 * �bergabeparameter:	Mitarbeiterid
	 * 						Aktivstatus
	 */
	public function aktiviere_mitarbeiter_durch_id($mid, $aktiv)
	{
		mysql_query("UPDATE mitarbeiter SET aktiv=".$aktiv." WHERE mid='".$mid."'");
	}

	/* Testet die �bergebene E-Mail, ob sie bereits in der Datenbank vorhanden ist
	 * �bergabeparameter: E-Mail
	 * R�ckgabewert:	True (E-Mail bereits vorhanden)
	 * 					False (E-Mail noch nicht vorhanden)
	 */
	public function teste_email($email)
	{
		$puffer = mysql_query("SELECT * FROM mitarbeiter WHERE email='".$email."'");
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