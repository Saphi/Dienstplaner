<?php
 class Dienstplan
 {
 	public $name;
 	
 	/* Konstruktor
 	 */
 	public function Dienstplan()
 	{
 		
 	}
        
        public function get_recent_plan_start()
	{
                $puffer = mysql_query("SELECT date FROM empshift ORDER BY date LIMIT 1");
		$dienstplan_objekt = mysql_fetch_object($puffer, 'Dienstplan' , array('date'));

		return $dienstplan_objekt;
        }
        
        public function get_recent_plan_end()
	{
                $puffer = mysql_query("SELECT date FROM empshift ORDER BY date DESC LIMIT 1");
		$dienstplan_objekt = mysql_fetch_object($puffer, 'Dienstplan' , array('date'));

		return $dienstplan_objekt;
        }
        
        public function get_weekdays()
	{
                $puffer = mysql_query("SELECT name FROM days");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
			$dienstplan_objekt_feld[] = $dienstplan_objekt['name'];
		}
		return $dienstplan_objekt_feld;
        }
        
        public function get_spec_times_business_off()
	{
                $puffer = mysql_query("SELECT start FROM spec_times_business WHERE open = 0");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                        $zw = explode("-",$dienstplan_objekt['start']);
                        $dienstplan_objekt_feld[] = $zw[2].'.'.$zw[1].'.'.$zw[0];
			
		}
		return $dienstplan_objekt_feld;
        }
        
        public function get_spec_times_business_on()
	{
                $puffer = mysql_query("SELECT start FROM spec_times_business WHERE open = 1");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                        $zw = explode("-",$dienstplan_objekt['start']);
                        $dienstplan_objekt_feld[] = $zw[2].'.'.$zw[1].'.'.$zw[0];
			
		}
		return $dienstplan_objekt_feld;
        }
        
        public function get_emp_ids()
	{
                $puffer = mysql_query("SELECT eid FROM employees");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                       
                        $dienstplan_objekt_feld[] =  $dienstplan_objekt['eid'];
			
		}
		return $dienstplan_objekt_feld;
        }
        
        public function get_vac()
	{
                $puffer = mysql_query("SELECT eid, start, end FROM employee_vac");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                        $zw = explode("-",$dienstplan_objekt['start']);
                        $dienstplan_objekt['start'] = $zw[2].'.'.$zw[1].'.'.$zw[0];
                        $zw = explode("-",$dienstplan_objekt['end']);
                        $dienstplan_objekt['end'] = $zw[2].'.'.$zw[1].'.'.$zw[0];
                        $dienstplan_objekt_feld[$dienstplan_objekt['eid']] =  $dienstplan_objekt['start'].'-'.$dienstplan_objekt['end'];
			
		}
		return $dienstplan_objekt_feld;
        }
        
         public function get_missed_times()
	{
                $puffer = mysql_query("SELECT employees_eid, start, end FROM times_missed_employees");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                        $zw = explode("-",$dienstplan_objekt['start']);
                        $dienstplan_objekt['start'] = $zw[2].'.'.$zw[1].'.'.$zw[0];
                        $zw = explode("-",$dienstplan_objekt['end']);
                        $dienstplan_objekt['end'] = $zw[2].'.'.$zw[1].'.'.$zw[0];
                        $dienstplan_objekt_feld[$dienstplan_objekt['employees_eid']] =  $dienstplan_objekt['start'].'-'.$dienstplan_objekt['end'];
			
		}
		return $dienstplan_objekt_feld;
        }
               
         public function get_emp_spec_times()
	{
                $puffer = mysql_query("SELECT employees_eid, shifts_sid FROM spec_times_employees");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                        $shift_nick = mysql_fetch_assoc(mysql_query("SELECT nick FROM shifts WHERE sid = '".$dienstplan_objekt['shifts_sid']."'"));
                        $dienstplan_objekt_feld[$dienstplan_objekt['employees_eid']] =  $shift_nick['nick'];
			
		}
		return $dienstplan_objekt_feld;
        }
        
         public function get_all_shifts()
	{
                $puffer = mysql_query("SELECT sid, nick FROM shifts");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                        $dienstplan_objekt_feld[$dienstplan_objekt['sid']] =  $dienstplan_objekt['nick'];
			
		}
		return $dienstplan_objekt_feld;
        }
        
         public function get_all_shifts_full()
	{
                $dienstplan_objekt_feld = array();
		$puffer = mysql_query('SELECT sid, nick, color FROM shifts');
		while($dienstplan_objekt = mysql_fetch_object($puffer, 'Dienstplan' , array('sid', 'nick', 'color')))
		{
			$dienstplan_objekt_feld[] = $dienstplan_objekt;
		}
		return $dienstplan_objekt_feld;
        }
        
        public function get_shifts_must()
	{
                $puffer = mysql_query("SELECT sid, must FROM shift_must GROUP BY sid");
		while($dienstplan_objekt = mysql_fetch_assoc($puffer))
		{
                    $shift_nick = mysql_fetch_assoc(mysql_query("SELECT nick FROM shifts WHERE sid = '".$dienstplan_objekt['sid']."'"));   
                    $dienstplan_objekt_feld[$shift_nick['nick']] =  $dienstplan_objekt['must'];
			
		}
		return $dienstplan_objekt_feld;
        }
        
       
     

 }
 ?>