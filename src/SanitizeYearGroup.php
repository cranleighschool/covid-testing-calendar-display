<?php


namespace CranleighCovidTestingCalendar;


/**
 * Class SanitizeYearGroup
 * @package CranleighCovidTestingCalendar
 */
class SanitizeYearGroup
{
    /**
     * @var string
     */
    public $str;

    /**
     * SanitizeYearGroup constructor.
     *
     * @param  string  $str
     */
    public function __construct(string $str)
    {
        $this->str = $str;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getSanitizedYearGroup($this->str);
    }

    /**
     * @param  string  $str
     *
     * @return string
     */
    public function getSanitizedYearGroup(string $str): string
    {
        if (preg_match('/^\A(9|10|11|12|13)\z$/', $str)) {
            $int = (int) $str;
            switch ($int) {
                case 3:
                    return "Form 1";
                    break;
                case 4:
                    return "Form 2";
                    break;
                case 5:
                    return "Form 3";
                    break;
                case 6:
                    return "Form 4";
                    break;
                case 7:
                    return "Form 5";
                    break;
                case 8:
                    return "Form 6";
                    break;
                case 9:
                    return "IV Form";
                    break;
                case 10:
                    return "LV Form";
                    break;
                case 11:
                    return "UV Form";
                    break;
                case 12:
                    return "LVI Form";
                    break;
                case 13:
                    return "UVI Form";
                    break;
            }
        }

        return trim(ucwords(strtolower($str)));

    }
}
