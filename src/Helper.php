<?php

namespace CranleighCovidTestingCalendar;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;

/**
 * Class Helper
 * @package CranleighCovidTestingCalendar
 */
class Helper
{
    /**
     * @return array
     */
    public static function getBayCalendarEvents(): array
    {
        $bay1 = (new BayCalendar('BAY1'))->events;
        $bay2 = (new BayCalendar('BAY2'))->events;
        $bay3 = (new BayCalendar('BAY3'))->events;
        $bay4 = (new BayCalendar('BAY4'))->events;
        $bay5 = (new BayCalendar('BAY5'))->events;
        $bays = [
            $bay1, $bay2, $bay3, $bay4, $bay5,
        ];
        return $bays;
    }

    /**
     * @param  \Illuminate\Support\Collection  $bay
     * @param  \Carbon\Carbon  $date
     * @param  bool  $expectingJson
     *
     * @return object|string|null
     */
    public static function displayCalendarItem(Collection $bay, Carbon $date, bool $expectingJson = false)
    {
        $result = $bay->where("eventStartTime", "=", $date)->first();
        if (is_null($result)) {
            return null;
        }
        if ($expectingJson === true) {
            return (object) $result;
        }

        return '<div class="calendar-item house-'.$result[ 'pupilHouse' ].'"><span>'.$result[ 'pupilName' ].'</span><span>'.$result[ 'pupilHouse' ].'</span><span>'.$result[ 'pupilYearGroup' ].'</span></div>';
    }

    /**
     * Compute a range between two dates, and generate
     * a plain array of Carbon objects of each day in it.
     *
     * @param  \Carbon\Carbon  $from
     * @param  \Carbon\Carbon  $to
     * @param  bool  $inclusive
     *
     * @return array|null
     *
     * @author Tristan Jahier
     */
    public static function date_range(Carbon $from, Carbon $to, $inclusive = false)
    {
        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy();
        $to = $to->copy();

        // Include the end date in the range
        if ($inclusive) {
            $to->addDay();
        }

        $step = CarbonInterval::minutes(5);
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon($day);
        }

        return ! empty($range) ? $range : null;
    }

    /**
     * @param  string|null  $day
     *
     * @return array|null
     */
    public static function generateTimesForDay(string $day = null)
    {
        if ($day === 'Friday') {
            return self::date_range(Carbon::parse("2021-03-05 12:55:00"), Carbon::parse("2021-03-05 15:05:00"));
        }
        if ($day === 'Saturday') {
            return self::date_range(Carbon::parse("2021-03-06 8:30:00"), Carbon::parse("2021-03-06 17:30:00"));
        }
        if ($day === 'Sunday') {
            return self::date_range(Carbon::parse("2021-03-07 9:00:00"), Carbon::parse("2021-03-07 20:00:00"));
        }
    }
}
