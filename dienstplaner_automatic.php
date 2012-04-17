<?php
//phpinfo();
include('inc/config.php');
include('klassen/dienstplan.klasse.php');
$dienstplan_recent = new Dienstplan();
// Variables
$frequency = "";
// Date recent plan from DB
$plan_recent["start"] = $dienstplan_recent->get_recent_plan_start();
    $zw = explode("-",$plan_recent["start"]->date);
$plan_recent["start"] = $zw[2].'.'.$zw[1].'.'.$zw[0];
$plan_recent["end"] = $dienstplan_recent->get_recent_plan_end();
    $zw = explode("-",$plan_recent["end"]->date);
$plan_recent["end"] = $zw[2].'.'.$zw[1].'.'.$zw[0];

//echo $plan_recent["start"].' bis '.$plan_recent["end"].'<br/><br/>';
// frequency aus Textdatei: wöchentlich oder monatlich
$frequency = "weekly";

if($frequency == "weekly")
{
    $plan_dates = get_week();
    $plan_dates["start"] = date("d.m.Y", $plan_dates["start"]);    
    $plan_dates["end"] = date("d.m.Y", $plan_dates["end"]);
    //echo $plan_dates["start"] ."<br />";
    //echo $plan_dates["end"];
}elseif($frequency == "monthly")
{
    $plan_dates = get_month();
    //echo $plan_dates["start"] ."<br />";
    //echo $plan_dates["end"];
}

if($plan_recent["start"] == $plan_dates["start"] && $plan_recent["end"] == $plan_dates["end"])
{
    echo "Der aktuelle Dienstplan existiert bereits und wird nicht nochmal erstellt.";
}else
{
    $newplan = create_plan($plan_dates["start"], $plan_dates["end"]);
}

/**
 * Rückgabeparameter ist Array mit Datum Montag kommende Woche/Sonntag kommende Woche
 */
function get_week()
{
    $plan_dates = array();
    
    $plan_dates["start"] = strtotime("next Monday");
    $date = date("d.m.Y", $plan_dates["start"]);
    $plan_dates["end"] = strtotime("$date +6 days");
    
    return $plan_dates;
}

function get_month()
{
    $plan_dates = array();
    
    $date_now = date("d.m.Y");
    $date_now = explode(".", $date_now);

    switch($date_now[1])
    {
        case "01":
            $plan_dates["start"] = "01." ."02." .date("Y");
            
            if(date("Y")%4 == 0)
            {
                $plan_dates["end"] = "29." ."02." .date("Y");
            }else
            {
                $plan_dates["end"] = "28." ."02." .date("Y");
            }
            break;
       case "02":
            $plan_dates["start"] = "01." ."03." .date("Y");
            $plan_dates["end"] = "31." ."03." .date("Y");
            break;     
       case "03":
            $plan_dates["start"] = "01." ."04." .date("Y");
            $plan_dates["end"] = "30." ."04." .date("Y");
            break;
        case "04":
            $plan_dates["start"] = "01." ."05." .date("Y");
            $plan_dates["end"] = "31." ."05." .date("Y");
            break;
        case "05":
            $plan_dates["start"] = "01." ."06." .date("Y");
            $plan_dates["end"] = "30." ."06." .date("Y");
            break;
        case "06":
            $plan_dates["start"] = "01." ."07." .date("Y");
            $plan_dates["end"] = "31." ."07." .date("Y");
            break;
        case "07":
            $plan_dates["start"] = "01." ."08." .date("Y");
            $plan_dates["end"] = "31." ."08." .date("Y");
            break;
        case "08":
            $plan_dates["start"] = "01." ."09." .date("Y");
            $plan_dates["end"] = "30." ."09." .date("Y");
            break;
        case "09":
            $plan_dates["start"] = "01." ."10." .date("Y");
            $plan_dates["end"] = "31." ."10." .date("Y");
            break;
        case "10":
            $plan_dates["start"] = "01." ."11." .date("Y");
            $plan_dates["end"] = "30." ."11." .date("Y");
            break;
        case "11":
            $plan_dates["start"] = "01." ."12." .date("Y");
            $plan_dates["end"] = "31." ."12." .date("Y");
            break;
        case "12":
            $year = date("Y") + 1;
            $plan_dates["start"] = "01." ."01." .$year;
            $plan_dates["end"] = "31." ."01." .$year;
            break;
    }

    return $plan_dates;
}

/*
 * HAUPTFUNKTION! -> Erstellen des Dienstplanes
 */
function create_plan($start, $end)
{
    $dienstplan = new Dienstplan();
    $plan = array();
    echo "Der aktuelle Dienstplan fuer den Zeitraum $start bis $end wird nun erstellt.
        Bitte haben Sie einen Moment Geduld...";

    // simulated Database entries
    
    
    
    $workdays = array("Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag");   // DB-Eintrag --> SQL-Abfrage
    $spec_times_business_off = $dienstplan->get_spec_times_business_off();
    $spec_times_business_on =  $dienstplan->get_spec_times_business_on();
        
    if($spec_times_business_off == NULL)
    {
        $spec_times_business_off[] = 0;
    
    }
    if($spec_times_business_on == NULL)
    {
        $spec_times_business_on[] = 0;
    
    }

    
    $emp_db = $dienstplan->get_emp_ids();   
    
    
    $emp_db_vac = orderDates("vacation");//array("300_0" => "16.04.2012", "925_0" => "18.04.2012");
    $emp_db_times_missed = orderDates("missed_times");//array("315_0" => "19.04.2012", "316_0" => "04.04.2012");    
    
    // $emp_db_spec_times = array(228 => "FS", 809 => "NS");
    $emp_db_spec_times = $dienstplan->get_emp_spec_times(); 
    
    //  $emp_db_hours = array(300 => 20, 809 => 1, 953 => -1, 316 => -17);      // DB-Eintrag --> SQL-Abfrage
    
    // print_r(array_values($emp_db_hours));
    
    //$shifts = array(0 => "FS", 1 => "MS", 2 => "NS");
    $shifts = $dienstplan->get_all_shifts(); 
    
    //$shift_must = array("FS" => 3, "MS" => 2, "NS" => 1);
    $shift_must = $dienstplan->get_shifts_must(); 
    
    // Variables
    // $all_plans = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "");
    
    // days of timespan
    $timespan_dates = get_dates($start, $end);
    
    /*foreach($all_plans as $single_plan)
    {
        $single_plan = ;    // 5 different plans
    }*/
    
    foreach($timespan_dates as $timespan_date)
    {
        $emp_available = $emp_db;
        $day = get_weekday($timespan_date);
        //echo $day;
        
        if(in_array($day, $workdays) && 
                !in_array($timespan_date, $spec_times_business_off) || 
                in_array($timespan_date, $spec_times_business_on))
        {
            //echo "<br />$timespan_date: Arbeitstag<br />";
            
            if(in_array($timespan_date, $emp_db_vac)) // wenn Mitarbeiter Urlaub, dann aus array gelöscht
            {
                $key = array_search($timespan_date, $emp_db_vac);
                $key = explode("_", $key);
                //echo "Mitarbeiter $key[0] hat Urlaub.<br />";
                $key = array_search($key[0], $emp_available);
                unset($emp_available[$key]);
            }
            if(in_array($timespan_date, $emp_db_times_missed))  // wenn Mitarbeiter besondere Ausfallzeiten, dann aus array gelöscht
            {
                $key = array_search($timespan_date, $emp_db_times_missed);
                $key = explode("_", $key);
                //echo "Mitarbeiter $key[0] hat Sondertag.<br />";
                $key = array_search($key[0], $emp_available);
                unset($emp_available[$key]);
            }            
            
            foreach($shifts as $shift)
            {
                $shift_have = 0;
                $shift_dates[$timespan_date][] = $shift;    // jedem verfügbaren Datum werden jeweils schihcten zugeteilt
                
                $av_emps = $emp_available;
                
                if($shift_must[$shift] > 0)
                {
                    //echo "$shift: ".$shift_must[$shift] ."<br />";  // Ausgabe der Arbeitstage mit schichten und schichtsoll
                    //  echo $shift;
                    // deleting employees with special times
                    if(in_array($shift, $emp_db_spec_times))
                    {
                        $key = array_search($shift, $emp_db_spec_times);
                        //echo "Mitarbeiter $key hat fuer Schicht $shift eine Sonderzeit.<br />";
                        $key = array_search($key, $av_emps);
                        unset($av_emps[$key]);
                    }
                                       
                    /*echo "Fuer $timespan_date und Schicht $shift verfuegbare Mitarbeiter sind: <br />";*/
                    $available_workers = array();
                    // Ruhezeiten
                    foreach($av_emps as $av_emp)
                    {
                        //echo $av_emp ."<br />";
                        $time_difference = restingTime($timespan_date, $av_emp, $shift, $plan);
                        if($time_difference < 11)
                        {
                            //echo "Bei $av_emp sind Ruhestunden NICHT eingehalten.<br />";
                        }else
                        {
                            //echo "Bei $av_emp sind Ruhestunden eingehalten.<br />";
                            
                            $available_workers[] = $av_emp;
                            
                        }
                    }
                    //  print_r($available_workers);
                    //  put employees into shifts
                    do{
                        
                        $worker = array_rand($available_workers, 1);

                        $plan[$timespan_date][$shift][] = $available_workers[$worker];

                        unset($available_workers[$worker]);  
                        $shift_have += 1;
                   }while($shift_have < $shift_must[$shift]);
                    
                   
                    // var_dump($av_emp);
                }
            }

        }
        
    }
    //var_dump($shift_dates);   // alle schichten für jeden verfügbaren Tag
    //var_dump($emp_db);    // alle verfügbaren Mitarbeiter sind enthalten in $emp_db
    
    //  Ausgabe erstellter Plan!!!
      /*
      echo "<br /><br />Dienstplan von $start bis $end:<br />";
      foreach($plan as $date => $shift)
      {
          echo "Datum: $date<br />";
          
          foreach($shifts as $shift)
          {
              echo "Schicht: $shift: <br />";
              foreach($plan[$date][$shift] as $key => $emp)
              {
                  $key += 1;
                  echo "$key. Mitarbeiter: $emp<br />";
              }
          }
      }
      */
      return $plan;
}

function get_dates($start, $end)
{
    // zu belegende Tage ermitteln
    
    $i = 0;
    $timespan_dates[$i] = $start;
    //echo $timespan_dates[$i];
    
    do{
        $date = $timespan_dates[$i];
        $date = strtotime("$date +1 day");
        $timespan_dates[$i+1] = date("d.m.Y", $date);
        $i++;
    } while(strtotime($timespan_dates[$i]) < strtotime($end));

    return $timespan_dates;
}

function get_weekday($date)
{
    $date = explode(".", $date);
    $weekday = mktime(0,0,0,$date[1],$date[0],$date[2]);
    $day = date('w',$weekday);
              
    switch($day)
    {
        case 0:
            $day = "Sonntag";
            break;
        case 1:
            $day = "Montag";
            break;
        case 2:
            $day = "Dienstag";
            break;
        case 3:
            $day = "Mittwoch";
            break;
        case 4:
            $day = "Donnerstag";
            break;
        case 5:
            $day = "Freitag";
            break;
        case 6:
            $day = "Samstag";
            break;
    }
        
    return $day;
}

//  Ermittlung der Ruhezeit
function restingTime ($date, $employee, $shift, $plan)
{
    //print_r($plan);
    //$key = array_search($plan[$date][$employee][$shift]);
    $day_before_date = strtotime("$date -1 day");
    $day_before_date = date("d.m.Y", $day_before_date);
        
    if(isset($plan[$date]))
    {
        //echo "Eintrag im Dienstplaner fuer $date gibts schon.<br />";
        
        foreach($plan as $dates => $shifts)
        {
            $i = 0;
            
            foreach($shifts as $shift => $emps)
            {
                //print_r($shifts);
                //echo $plan[$date][$shift][$employee];
                $amount_emps = count($emps);
                for($j = 0; $j < $amount_emps; $j++)
                {
                    if(isset($plan[$date][$shift]))
                    {
                        if($plan[$date][$shift][$j] == $employee)
                        {
                            //echo "Mitarbeiter $employee schon gesetzt fuer $date und $shift.<br />";
                            $i += 1;                    
                        }
                    }                    
                }                               
            }
            
            if($i > 0)
            {
                $time_difference = 10;  // in Hinblick auf zukünftige ruhestunden
            }else
            {
                $time_difference = 11;        
            }
        }
    }else
    {
        //echo "Kein Eintrag fuer $date existent.<br />";
        $time_difference = 11;
    }
    
    // Search for employee in recent plan saved in DB: get date and shift
    /*$last_shift_date = "16.04.2012";   // DB-Eintrag --> SQL-Abfrage    
    $last_shift = "FS";   // DB-Eintrag --> SQL-Abfrage    
    $last_shift_endtime = "14:00";   // DB-Eintrag --> SQL-Abfrage
    $recent_shift_starttime = "01:00";   // DB-Eintrag --> SQL-Abfrage; time for parameter $shift
    */
    //  recent_date - 1 day
    //$day_before_date = strtotime("$date -1 day");
    //$day_before_date = date("d.m.Y", $day_before_date);
    
    /*if($last_shift_date == $day_before_date || $date == $last_shift_date)
    {
        //echo "aha<br />";
        
        $last_shift_endtime = explode(":", $last_shift_endtime);
        $recent_shift_starttime = explode(":", $recent_shift_starttime);
        $date = explode(".", $date);
        $last_shift_endtime = mktime($last_shift_endtime[0],$last_shift_endtime[1],0,$date[1],$date[0],$date[2]);
        $recent_shift_starttime = mktime($recent_shift_starttime[0],$recent_shift_starttime[1],0,$date[1],$date[0],$date[2]);
        
        $time_difference = abs($recent_shift_starttime - $last_shift_endtime);
        $time_difference = date('G',$time_difference);
        if($time_difference > 12)
        {
            $rest = $time_difference % 12;
            $time_difference -= $rest +1;
        }else
        {
            $time_difference -= 1;
        }
        
    }else
    {
        $time_difference = 11;
    }*/
    return $time_difference;
}


function orderDates($reason)
{
    $dienstplan_orderdates = new Dienstplan();
    if($reason == "vacation")
    {
         //$emp_vacs = array(1 => "16.04.2012-20.04.2012", 315 => "19.04.2012");
        $emp_vacation[] = $dienstplan_orderdates->get_vac(); 
    
        foreach($emp_vacation as $emp_vacs)
        {
            foreach($emp_vacs as $emp => $emp_vac)
            {
                if(strlen($emp_vac) > 10)
                {
                    $emp_vac = explode("-", $emp_vac);
                    $start = $emp_vac[0];
                    $end = $emp_vac[1];

                    $timespans = get_dates($start, $end);

                    foreach($timespans as $timespan)
                    {
                        $key = "$emp"."_$timespan";                                
                        $all_dates[$key] = $timespan;
                    }

                }else
                {
                    $key = "$emp"."_$emp_vac";                                
                    $all_dates[$key] = $emp_vac;
                }

            }
        }
        
        
        
    }elseif($reason == "missed_times")
    {
        //$emp_missed_times = array(925 => "19.04.2012-20.04.2012", 328 => "18.04.2012");
        $missed_times[] = $dienstplan_orderdates->get_missed_times();  
        
        foreach($missed_times as $emp_missed_times)
        {
            foreach($emp_missed_times as $emp => $emp_missed_time)
            {
                if(strlen($emp_missed_time) > 10)
                {
                    $emp_missed_time = explode("-", $emp_missed_time);
                    $start = $emp_missed_time[0];
                    $end = $emp_missed_time[1];

                    $timespans = get_dates($start, $end);

                    foreach($timespans as $timespan)
                    {
                        $key = "$emp"."_$timespan";    
                        $all_dates[$key] = $timespan;
                    }

                }else
                {
                    $key = "$emp"."_$emp_missed_time";                                
                    $all_dates[$key] = $emp_missed_time;
                }
            }
        }
    }
    
    return $all_dates;   // alle daten, die mitarbeiter nicht da ist (ob vacation or missed times)
}

?>
