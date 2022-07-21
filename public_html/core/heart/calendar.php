<?
/**
 * Calendar
 * https://snipp.ru/php/php-calendar
 */
class calendar
{
	/**
	 * Вывод календаря на один месяц.
	 */
	public static function  getMonth($month, $year, $events = array())
	{
		$oLang = new lang();

		$months = array(
			1  => $oLang->get('January'),
			2  => $oLang->get('February'),
			3  => $oLang->get('March'),
			4  => $oLang->get('April'),
			5  => $oLang->get('May'),
			6  => $oLang->get('June'),
			7  => $oLang->get('July'),
			8  => $oLang->get('August'),
			9  => $oLang->get('September'),
			10 => $oLang->get('October'),
			11 => $oLang->get('November'),
			12 =>$oLang->get('December'),
		);

		$month = intval($month);
		$out = '
		<div class="calendar-item">
			<div class="calendar-head">' . $months[$month] . ' ' . $year . '</div>
			<table>
				<tr>
					<th>' . $oLang->get('Mo') . '</th>
					<th>' . $oLang->get('Tu') . '</th>
					<th>' . $oLang->get('We') . '</th>
					<th>' . $oLang->get('Th') . '</th>
					<th>' . $oLang->get('Fr') . '</th>
					<th>' . $oLang->get('Sa') . '</th>
					<th>' . $oLang->get('Su') . '</th>
				</tr>';

		$day_week = date('N', mktime(0, 0, 0, $month, 1, $year));
		$day_week--;

		$out.= '<tr>';

		for ($x = 0; $x < $day_week; $x++) {
			$out.= '<td></td>';
		}

		$days_counter = 0;
		$days_month = date('t', mktime(0, 0, 0, $month, 1, $year));

		for ($day = 1; $day <= $days_month; $day++) {
			if (date('j.n.Y') == $day . '.' . $month . '.' . $year) {
				$class = 'today';
			} elseif (time() > strtotime($day . '.' . $month . '.' . $year)) {
				$class = 'last';
			} else {
				$class = '';
			}

			$event_show = false;
			$event_text = array();
			if (!empty($events)) {
				foreach ($events as $date => $text) {
					$date = explode('.', $date);
					if (count($date) == 3) {
						$y = explode(' ', $date[2]);
						if (count($y) == 2) {
							$date[2] = $y[0];
						}

						if ($day == intval($date[0]) && $month == intval($date[1]) && $year == $date[2]) {
              if ( (int)$text ) {
                $event_show = true;
                $event_text[] = $text;
              }
						}
					} elseif (count($date) == 2) {
						if ($day == intval($date[0]) && $month == intval($date[1])) {
              if ( (int)$text ) {
                $event_show = true;
                $event_text[] = $text;
              }
						}
					} elseif ($day == intval($date[0])) {
            if ( (int)$text ) {
              $event_show = true;
              $event_text[] = $text;
            }
					}
				}
			}

			if ($event_show) {
				$out.= '<td class="calendar-day ' . $class . ' event _level_' . implode('<br>', $event_text) . '">' . $day;
				if (!empty($event_text)) {
					// $out.= '<div class="calendar-popup">' . implode('<br>', $event_text) . '</div>';
				}
				$out.= '</td>';
			} else {
				$out.= '<td class="calendar-day ' . $class . '">' . $day . '</td>';
			}

			if ($day_week == 6) {
				$out.= '</tr>';
				if (($days_counter + 1) != $days_month) {
					$out.= '<tr>';
				}
				$day_week = -1;
			}

			$day_week++;
			$days_counter++;
		}

		$out .= '</tr></table></div>';
		return $out;
	}

	/**
	 * Вывод календаря на несколько месяцев.
	 */
	public static function  getInterval($start, $end, $events = array())
	{
		$curent = explode('.', $start);
		$curent[0] = intval($curent[0]);

		$end = explode('.', $end);
		$end[0] = intval($end[0]);

		$begin = true;
		$out = '<div class="calendar-wrp">';
		do {
			$out .= self::getMonth($curent[0], $curent[1], $events);

			if ($curent[0] == $end[0] && $curent[1] == $end[1]) {
				$begin = false;
			}

			$curent[0]++;
			if ($curent[0] == 13) {
				$curent[0] = 1;
				$curent[1]++;
			}
		} while ($begin == true);

		$out .= '</div>';
		return $out;
	}
}
