<?php

namespace App\Includes;

use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\LarouxJs\LarouxJs;
use Scabbia\Request;

/**
 * @ignore
 */
class ViewHelpers
{
    public static $months = array(
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );


    /**
     * @ignore
     */
    public static function printBool($uCondition)
    {
        if ($uCondition === true || intval($uCondition) === 1) {
            return I18n::_('Yes');
        }

        return I18n::_('No');
    }

    /**
     * @ignore
     */
    public static function printDate($uDate, $uIncludeHour = false)
    {
        if ($uDate === '' || $uDate === null) {
            return I18n::_('(Unspecified)');
        }

        return Date::convert($uDate, 'Y-m-d H:i:s', $uIncludeHour ? 'd/m/Y H:i' : 'd/m/Y');
    }

    /**
     * @ignore
     */
    public static function printProject($uProject)
    {
        return '<a href="' . Http::url('projects/show/' . $uProject['id']) . '">' . $uProject['title'] . '</a>';
    }

    /**
     * @ignore
     */
    public static function printProjectId($uProjectId, $uProjectName, $uProjectTitle)
    {
        return '<a href="' . Http::url('projects/show/' . $uProjectId) . '">' . $uProjectTitle . '</a>';
    }

    /**
     * @ignore
     */
    public static function printTask($uTask, $uAlwaysShowPercentage = false)
    {
        $tReturn = '<a href="' . Http::url('projects/tasks/' . $uTask['project'] . '/detail/' . $uTask['id']) . '">' . $uTask['subject'] . '</a>';
        if ($uAlwaysShowPercentage || $uTask['progress'] > 0 && $uTask['progress'] < 100) {
            $tReturn .= ' (' . $uTask['progress'] . '%)';
        }

        return $tReturn;
    }

    /**
     * @ignore
     */
    public static function printUser($uUser)
    {
        if ($uUser === null) {
            return I18n::_('(Unassigned)');
        }

        return '<a href="#">' . $uUser['name'] . '</a>'; // ' . Http::url('users/show/' . $uUser['id']) . '
    }

    /**
     * @ignore
     */
    public static function printGroup($uGroup)
    {
        if ($uGroup === null) {
            return I18n::_('(Unassigned)');
        }

        return '<a href="#">' . $uGroup['name'] . '</a>'; // ' . Http::url('groups/show/' . $uGroup['id']) . '
    }

    /**
     * @ignore
     */
    public static function printUserId($uUserId, $uUserName)
    {
        if ($uUserId === 0) {
            return I18n::_('(Unassigned)');
        }

        return '<a href="#">' . $uUserName . '</a>'; // ' . Http::url('users/show/' . $uUserId) . '
    }

    /**
     * @ignore
     */
    public static function printStatus($uConstants, $uStatusId)
    {
        if (isset($uConstants['open_task_type'][(int)$uStatusId])) {
            echo $uConstants['open_task_type'][(int)$uStatusId]['name'];
        } elseif (isset($uConstants['closed_task_type'][(int)$uStatusId])) {
            echo $uConstants['closed_task_type'][(int)$uStatusId]['name'];
        } else {
            echo '- ' . I18n::_('Unspecified');
        }
    }

    /**
     * @ignore
     */
    public static function printConstant($uConstants, $uKey, $uValue)
    {
        $uIntValue = (int)$uValue;

        if ($uIntValue !== 0 && isset($uConstants[$uKey][$uIntValue])) {
            echo $uConstants[$uKey][$uIntValue]['name'];
        } else {
            echo '- ' . I18n::_('Unspecified');
        }
    }

    /**
     * @ignore
     */
    public static function printPage($uPage)
    {
        return '<a href="' . Http::url('page/' . $uPage['name']) . '">' . $uPage['title'] . '</a>';
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param int $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g')
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";

        return $url;
    }

    /* draws a calendar */
    public static function draw_calendar($month, $year, $data)
    {

        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array(
            I18n::_('Monday'),
            I18n::_('Tuesday'),
            I18n::_('Wednesday'),
            I18n::_('Thursday'),
            I18n::_('Friday'),
            I18n::_('Saturday'),
            I18n::_('Sunday')
        );

        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">' .
            implode('</td><td class="calendar-day-head">', $headings) .
            '</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('N', mktime(0, 0, 0, $month, 1, $year)) - 1;
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar .= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++) {
            $calendar .= '<td class="calendar-day-np"><ul class="entries"></ul></td>';
            $days_in_this_week++;
        }

        /* keep going with days.... */
        for($list_day = 1; $list_day <= $days_in_month; $list_day++) {
            $calendar .= '<td class="calendar-day">';
            /* add in the day number */
            $calendar .= '<div class="day-number">' . $list_day . '</div>';

            /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
            $calendar .= '<ul class="entries">';
            if (isset($data[$list_day])) {
                foreach ($data[$list_day] as $tEntry) {
                    $calendar .= '<li>' . $tEntry . '</li>';
                }
            }
            $calendar .= '</ul>';

            $calendar.= '</td>';
            if($running_day == 6) {
                $calendar .= '</tr>';
                if(($day_counter + 1) != $days_in_month) {
                    $calendar .= '<tr class="calendar-row">';
                }

                $running_day = -1;
                $days_in_this_week = 0;
            }

            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        }

        /* finish the rest of the days in the week */
        if($days_in_this_week < 8) {
            for($x = 1; $x <= (8 - $days_in_this_week); $x++) {
                $calendar.= '<td class="calendar-day-np"><ul class="entries"></ul></td>';
            }
        }

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
        $calendar.= '</table>';

        /* all done, return result */
        return $calendar;
    }
}
