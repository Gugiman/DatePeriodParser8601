# DatePeriodParser8601
PHP Class for rudimental parsing ob ISO8601 DatePeriods user e.g. by Amazon Alexas Slot type "AMAZON.DATE"

## Using
Use like seen in test.php

```php
<?php

include_once "DatePeriodParser8601.php";

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