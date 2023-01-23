# DatePeriodParser8601
PHP Class for rudimental parsing of ISO8601 DatePeriods e.g. by Amazon Alexas Slot type [AMAZON.DATE](https://developer.amazon.com/de/docs/custom-skills/slot-type-reference.html#date)

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

//$string = "2019-05-10";
//$string = "2019-05";
//$string = "201X";
$string = "2019-W25-WE";
$obj = new DatePeriodParser8601($string);

$obj->getStart();
// returns \DateTime object of start

// $obj->getStart()->format("d.m.Y H:i:s");
// returns 22.06.2019 00:00:00

$obj->getEnd();
// returns \DateTime object of end

// $obj->getEnd()->format("d.m.Y H:i:s");
// returns 23.06.2019 23:59:59

// returns \DatePeriod object with given interval
$obj->asDatePeriod(new \DateInterval("P1D"));
```

## Donation

BTC: 1Gn4ofNXpvwYSvyi2wC1kT3Hoas3kaifqx

ETH (ERC20): 0x07d2b052abb86df996276fcc327296f344781ae8
