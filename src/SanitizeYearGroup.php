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
                case "Form IV":
                case "4TH":
                case "1V":
                case "IV FORM":
                    return self::FOUTH_FORM;

                case "L5":
                case "LOWER 5TH":
                case "LVTH":
                case "LV":
                case "L5TH":
                    return self::LOWERFIFTH;

                case "YEAR 11":
                case "UV":
                    return self::UPPERFIFTH;

                case "L6TH":
                case "LVI":
                case "LOWER 6":
                case "L6":
                case "LOWER VI":
                    return self::LOWERSIXTH;

                case "UPPER 6":
                case "UVI":
                    return self::UPPERSIXTH;

            }
        }


        return trim(ucwords(strtolower($str)));

    }
}
