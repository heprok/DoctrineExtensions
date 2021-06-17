<?php

namespace DoctrineExtensions\Types;

use DateInterval;
use DatePeriod;
use DateTime;

class DatePeriodRange extends DatePeriod
{
    const REGULAR_DATE_FROM_DB = '/(?<included_start>\[|\()"?(?<date_start>[T\d\-\s:+]+)"?,"?(?<date_end>[T\d\-\s:+]*|null)"?(?<included_end>]|\))/';
    public function __toString()
    {
        $format = self::EXCLUDE_START_DATE ? '[' : '(';
        $format .= '%s,' . ($this->end ? '%s' : '') . ')';

        return sprintf($format, $this->start->format(DATE_ATOM), $this->end ? $this->end->format(DATE_ATOM) : '');
    }

    public static function fromString(string $string): self
    {
        preg_match(self::REGULAR_DATE_FROM_DB, $string, $matches);
        $start = new DateTime($matches['date_start']);
        $interval = new DateInterval('P1D');
        $isIncludedStart = $matches == '[' ? 1 : 0;
        if ($matches['date_end'] == 'null' || $matches['date_end'] == '') {
            return new self($start, $interval, 1, $isIncludedStart);
        } else {
            $end = new DateTime($matches['date_end']);
            return new self($start, $interval, $end, $isIncludedStart);
        }
    }

    public static function fromPeriod(DatePeriod $period): self
    {
        return $period->end ?
            new self($period->start, $period->getDateInterval(), $period->end, $period->include_start_date)
            :
            new self($period->start, $period->getDateInterval(), 1, $period->include_start_date);
    }
}
