<?php
class Kalender
{
	public $monat;
	public $jahr;
	public $monats_name = array( '01' => 'Januar',
					      		 '02' => 'Februar',
					      		 '03' => 'März',
					       		 '04' => 'April',
					      	   	 '05' => 'Mai',
					      		 '06' => 'Juni',
					      		 '07' => 'Juli',
					      		 '08' => 'August',
							     '09' => 'September',
							     '10' => 'Oktober',
							     '11' => 'November',
					             '12' => 'Dezember' );
	
	/* setzt den Termin des Kalenders unter Berücksichtigung der führenden 0 beim Monat
	 * Übergabeparameter: 	Monat
	 * 						Jahr
	 */
	public function setze_termin($monat, $jahr)
	{
		if($monat<10)
		{
			$monat = '0'.$monat;
		}
		$this->monat = $monat;
		$this->jahr = $jahr;
	}
	
	/* holt den Vormonat und das zugehörige Jahr unter Berücksichtigung des Jahressprung bei Januar
	 * Rückgabewert:	Feld[2] -> Vormonat, zugehöriges Jahr
	 */
	public function hole_vor_monat()
	{
		if($this->monat=='1')
		{
			return array('12', $this->jahr-1);
		}
		else
		{
			return array($this->monat-1, $this->jahr);
		}
	}
	
	/* holt den Nachmonat und das zugehörige Jahr unter Berücksichtigung des Jahressprung bei Dezember
	 * Rückgabewert:	Feld[2] -> Nachmonat, zugehöriges Jahr
	 */
	function hole_nach_monat()
	{
		if($this->monat=='12')
		{
			return array('1', $this->jahr+1);
		}
		else
		{
			return array($this->monat+1,$this->jahr);
		}
	}
	
	/* Baut ein Feld[6][7] aus 6 Wochen mit jeweils 7 Tagen zusammen in dem die Monatstage gespeichert werden.
	 * Freie Felder vorher werden mit den letzten Monatstagen des Vormonats gefüllt und nachfolgende freie Felder mit dem Begin der Monatstage des Folgemonats.
	 * Rückgabewert:	Feld[6][7] -> Vormonatstage, Monatstage, Folgemonatstage
	 */	
	function hole_kalender()
	{
		$vor = $this->hole_vor_monat();
		$start = date('N', mktime(0,0,0,$this->monat,1,$this->jahr));
		$start_max = date('t', mktime(0,0,0,$vor[0],1,$vor[1]));
		$pre_max = date('t', mktime(0,0,0,$vor[0],1,$vor[1]));
		
	    $pre_start = $pre_max - $start + 2;
		
		$tag_2  = 1;
		$test = false;
		$neu  = 1;
		
		for($woche=1;$woche<7;$woche++)
		{
			for($tag=1;$tag<8;$tag++)
			{
				if($start==$tag)
				{
					$test=true;
				}
			 	if($test==false)
			 	{
			 		$monats_feld[$woche-1][$tag-1] = $pre_start;
			 		$pre_start++;
			 	}
			 	else
			 	{
					if($tag_2<=$start_max)
					{
						if($tag_2<10)
						{
							$tag_2 = '0'.$tag_2;
						}
						$monats_feld[$woche-1][$tag-1] = $tag_2;
						$tag_2++;
					}
					else
					{
						if($neu<10)
						{
							$neu = '0'.$neu;
						}
						$monats_feld[$woche-1][$tag-1] = $neu;
						$neu++;
					}
			 	}
			}
		}
		return $monats_feld;
	}
}
?>