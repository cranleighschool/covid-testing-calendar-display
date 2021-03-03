<?php


namespace CranleighCovidTestingCalendar;


/**
 * Class SanitizeYearGroup
 * @package CranleighCovidTestingCalendar
 */
class SanitizeYearGroup
{
    public const FOUTH_FORM = "Fouth Form";
    public const LOWERFIFTH = "Lower Fifth";
    public const UPPERFIFTH = "Upper Fifth";
    public const LOWERSIXTH = "Lower Sixth";
    public const UPPERSIXTH = "Upper Sixth";
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
                case 9:
                    return self::FOUTH_FORM;
                    break;
                case 10:
                    return self::LOWERFIFTH;
                    break;
                case 11:
                    return self::UPPERFIFTH;
                    break;
                case 12:
                    return self::LOWERSIXTH;
                    break;
                case 13:
                    return self::UPPERSIXTH;
                    break;
            }
        } else {
            switch (strtoupper($str)) {
                case "9 (FOURTH FORM)":
                    return self::FOUTH_FORM;
                case "L5":
                case "LVTH":
                case "LV":
                    return self::LOWERFIFTH;
                    break;
                case "UV":
                    return self::UPPERFIFTH;
                    break;
            }
        }


        return trim(ucwords(strtolower($str)));

    }
}
