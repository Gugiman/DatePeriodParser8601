<?php

namespace Gugiman;

/**
 * Class DatePeriodParser8601
 */
class DatePeriodParser8601
{

    /**
     * @var string
     */
    private $dateString;

    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * DatePeriodParser8601 constructor.
     * @param string $dateString
     */
    public function __construct(string $dateString)
    {

        $this->dateString = $dateString;

        try {
            $this->process();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @return bool
     * @throws Exception
     */
    private function process()
    {

        // Weeknumber
        if (strstr($this->dateString, "W")) {
            return $this->processWithWPlaceholder();
        }

        // Placeholder
        if (strstr($this->dateString, "X")) {

            $dateStringExploded = explode("-", $this->dateString);

            // if single year with placeholder
            if (count($dateStringExploded) == 1) {
                return $this->processWithYearXPlaceholder($dateStringExploded[0]);
            }

            // remove placeholder when no further information given
            foreach ($dateStringExploded as $key => $value) {

                if (strstr($value, "X")) {
                    unset($dateStringExploded[$key]);
                }
            }

            $this->dateString = implode("-", $dateStringExploded);
            $this->processWithNoPlaceholder();

            return true;
        } else {

            try {
                $date = new \DateTime($this->dateString);
                $this->processWithNoPlaceholder();
                return true;

            } catch (\Exception $e) {
                throw new \Exception('No format detected');
            }
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function processWithNoPlaceholder()
    {

        $dateStringExploded = explode("-", $this->dateString);
        $date = new \DateTime($this->dateString);

        switch (count($dateStringExploded)) {
            case 1:
                $this->start = clone $date->setDate($dateStringExploded[0], 1, 1)->setTime(0, 0, 0);
                $this->end = clone $date->setDate($dateStringExploded[0], 12, 31)->setTime(23, 59, 59);
                break;
            case 2:
                $this->start = clone $date->setDate($dateStringExploded[0], $dateStringExploded[1], 1)->setTime(0, 0,0);
                $this->end = clone $date->setDate($dateStringExploded[0], $dateStringExploded[1],$date->format("t"))->setTime(23, 59, 59);
                break;
            case 3:
                $this->start = clone $date->setTime(0, 0, 0);
                $this->end = clone $date->setTime(23, 59, 59);
                break;
        }

        return true;
    }

    /**
     * @param string $yearString
     * @return bool
     * @throws Exception
     */
    private function processWithYearXPlaceholder(string $yearString)
    {
        $xCount = substr_count($yearString, "X");
        $yearString = str_replace("X", "0", $yearString);
        (int)$yearString = str_pad($yearString, 4, "0");
        $date = new \DateTime($yearString);

        $this->start = clone $date->setDate($yearString, 1, 1)->setTime(0, 0, 0);
        $this->end = clone $date->setDate(($yearString + (pow(10, $xCount) - 1)), 12, 31)->setTime(23, 59, 59);

        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function processWithWPlaceholder()
    {

        $dateStringExploded = explode("-", $this->dateString);

        if (strstr($dateStringExploded[1], "W")) {
            $weekNumber = str_replace("W", "", $dateStringExploded[1]);
            $week_start = new \DateTime();
            $week_start->setISODate($dateStringExploded[0], $weekNumber);
            $this->start = clone $week_start->setTime(0, 0, 0);
            if (isset($dateStringExploded[2]) && $dateStringExploded[2] == "WE") {
                $this->start->add(new \DateInterval("P5D"));
            }
            $this->end = clone $week_start->add(new \DateInterval("P6D"))->setTime(23, 59, 59);
            return true;
        }

    }

    /////////////////////////
    /* CONVERTER */
    /////////////////////////

    /**
     * @param DateInterval $interval
     * @return bool|DatePeriod
     */
    public function asDatePeriod(\DateInterval $interval)
    {

        try {
            return new \DatePeriod($this->start, $interval, $this->end);
        } catch (\Exception $e) {
            return false;
        }

    }

    /////////////////////////
    /* GETTERS */
    /////////////////////////

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

}

