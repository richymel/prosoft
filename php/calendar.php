<html>
<head>
	<title>CALENDAR PROJECT - RESULTS for PROSOFT</title>
	<link rel="stylesheet" href="../css/calendar.css" type="text/css" charset="utf-8"/>   
</head>
<body>
<?php 
/*
	echo $_POST["usrDate"] . "<br>";
	echo $_POST["nbrDays"] . "<br>"; 
	echo $_POST["ctryCode"] . "<br>"; 
	echo $_POST["hdMonths"] . "<br>"; 
	echo $_POST["hdEndDate"] . "<br>"; 
	*/
	$country = $_POST["ctryCode"];
	$myDate = $_POST["usrDate"];
	$months = $_POST["hdMonths"];
	$endDate = $_POST["hdEndDate"];
	list($month, $day, $year1) = split('[/.-]', $myDate);
	list($year2,$month2,$day2)= split('[/.-]', $endDate);
	//echo $year2."--".$month2."--".$day2;
	$year = $year1; //initialize year
	//Do for as many months is needed:	
	for ($mm = 0; $mm <= $months; $mm++):		
		$myMonth = $month + $mm;
		//Check year rollover
		if ($myMonth>12) {
			//echo 'We have year rollover $mm:'.$mm.'$myMonth:'.$myMonth;
			$year = $year1 + intval($myMonth / 12.5);
			$myMonth -= intval($myMonth / 12.5) * 12;
			
			//echo '$myMonth:'.$myMonth.' year:'.$year;
		}
		if (strlen($myMonth)<2) {
			$myMonth = str_pad($myMonth, 2, '0', STR_PAD_LEFT);
		}

		$days_in_month = date('t',mktime(0,0,0,$myMonth,1,$year));
		
		//Next months always begin on first day.
		if ($mm>0) {
			$day = '01'; 
			//If it is the last month to process, assign last day passed in hdEndDate
			if ($myMonth==$month2) {
				$days_in_month = $day2;
			}						
		}
		//echo "myMonth:".$myMonth."</BR>";

		//echo "Days in month:".$days_in_month."<br>";
		echo getCal($country,$myMonth,$year,$day,$days_in_month);
	endfor;

function getCal($country,$month,$year,$startDay, $days_in_month){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('S','M','T','W','T','F','S');

	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* Month header */

	$calendar.= '<tr><td colspan="7" class="monthHeader">'.
		date("F",mktime(0,0,0,$month,1,$year))
		.' ' . $year.'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,$startDay,$year));
	//echo "Running day:".$running_day;	
	////$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	$monthsHolidays = getHolidays($country,$year,$month);

	//var_dump($monthsHolidays);
	//echo count($monthsHolidays['holidays']);

	/* keep going with days.... */
	for($list_day = $startDay; $list_day <= $days_in_month; $list_day++):
		$holiday = 0;
		for ($hd=0;$hd<count($monthsHolidays['holidays']);$hd++):
			if ($year."-".$month."-".$list_day == $monthsHolidays['holidays'][$hd]['date']) {
				$holiday = TRUE;
			}
		endfor;		

		if ($holiday) {
				$calendar.= '<td class="calendar-day-ho">';
		} else {
			if (strlen($list_day)<2) {
				$list_day = str_pad($list_day, 2, '0', STR_PAD_LEFT);
			}
			if (isWeekend($year.$month.$list_day)) {
				$calendar.= '<td class="calendar-day-we">';
			} else {
				$calendar.= '<td class="calendar-day">';
			}
		}

		//day numeral
		$calendar.= '<div class="day-number">'.$list_day.'</div>';
		$calendar.= str_repeat('<p> </p>',2);
		
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}

function isWeekend($date) {	
    $weekDay = date('w', strtotime($date));
    //echo $date."= ".$weekDay . " // ";
    return ($weekDay == 0 || $weekDay == 6);
}
function getHolidays($country,$year,$month) { 
	$json = file_get_contents("http://holidayapi.com/v1/holidays?country=".$country."&year=".$year."&month=".$month);
	return json_decode($json, TRUE);	
}
?>


</body>
</html>