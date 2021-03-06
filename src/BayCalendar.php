<?php


namespace CranleighCovidTestingCalendar;


use Carbon\Carbon;
use ICal\ICal;
use Illuminate\Support\Str;

/**
 * Class BayCalendar
 * @package App
 */
class BayCalendar
{
    /**
     * @var array
     */
    public $events;
    /**
     * @var string[]
     */
    private $keysToKeep = ['pupilName', 'pupilHouse', 'pupilYearGroup', 'eventStartTime', 'eventEndTime'];

    /**
     * BayCalendar constructor.
     *
     * @param  string  $bay
     */
    public function __construct(string $bay)
    {
        $this->bay = $bay;
        $ical = new ICal();
        $ical->initUrl($_ENV[ $bay ]);
        $this->events = collect(array_map([$this, 'mapper'], $ical->eventsFromInterval('1 week')));
    }

    /**
     * @param $item
     *
     * @return mixed
     */
    public function mapper($item)
    {
        $item->bay = $this->bay;
        $item->pupilName = $this->getPupilName($item->description);
        $item->pupilHouse = $this->getHouse($item->description);
        $item->pupilYearGroup = $this->getYearGroup($item->description);
        $item->eventStartTime = $this->getStartTime($item->dtstart);
        $item->eventEndTime = $this->getEndTime($item->dtend);

        $keys = array_keys(get_object_vars($item));
        foreach ($keys as $key) {
            if (! in_array($key, $this->keysToKeep)) {
                unset($item->$key);
            }
        }
        return (array) $item;
    }

    /**
     * @param  string  $startTime
     *
     * @return \Carbon\Carbon
     */
    private function getStartTime(string $startTime): Carbon
    {
        return Carbon::parse($startTime);
    }

    /**
     * @param  string  $endTime
     *
     * @return \Carbon\Carbon
     */
    private function getEndTime(string $endTime): Carbon
    {
        return Carbon::parse($endTime);
    }

    /**
     * @param  string  $summary
     *
     * @return string
     */
    private function getBookerName(string $summary)
    {
        return trim(str_replace("For Book your Covid Test", "", $summary));
    }

    /**
     * @param  string  $description
     *
     * @return int
     */
    private function getYearGroup(string $description): string
    {
        preg_match('/(Year Group|Yeargroup): [a-zA-Z0-9].*/', $description, $matches);

        $str = $matches[ 0 ];
        $str = str_replace("Yeargroup: ", "", $str);
        $str = trim(str_replace('Year Group: ', '', $str));
        return new SanitizeYearGroup($str);
    }

    /**
     * @param  string  $description
     *
     * @return string
     */
    private function getPupilName(string $description): string
    {
        preg_match('/Pupil Name: [a-zA-Z0-9].*/', $description, $matches);

        if (!empty($matches)) {
            $str = $matches[ 0 ];
            $str = trim(str_replace('Pupil Name: ', '', $str));
            return Str::title(strtolower($str));
        }

        return 'Unknown';
    }


    /**
     * @param  string  $description
     *
     * @return string
     */
    private function getHouse(string $description): string
    {
        preg_match('/House: [a-zA-Z]*/', $description, $matches);
        $str = $matches[ 0 ];

        $str = trim(str_replace("House: ", "", $str));
        if (strtolower($str)==='martlett') {
            return 'Martlet';
        }
        if (strtolower($str)==='cubit' || strtolower($str)==='cubbitt' || strtolower($str)==='cubbit') {
            return 'Cubitt';
        }
        return $str;

    }

}
