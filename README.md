# DatePeriodParser8601
PHP Class for rudimental parsing ob ISO8601 DatePeriods user e.g. by Amazon Alexas Slot type [AMAZON.DATE](https://developer.amazon.com/de/docs/custom-skills/slot-type-reference.html#date)

## Install via composer
Require the package with composer:
```
composer require gugiman/date-period-parser8601
```

## Using
Use like seen in test.php

```php
<?php

use Gugiman\DatePeriodParser8601;

//$string = "2015-12-10";
//$string = "2015-05";
//$string = "201X";
$string = "2015-W25-WE";
$obj = new DatePeriodParser8601($string);

// returns \DateTime object
$obj->getStart();

// returns \DateTime object
$obj->getEnd();

// returns \DatePeriod object with given interval
$obj->asDatePeriod(new \DateInterval("P1D"));
```
