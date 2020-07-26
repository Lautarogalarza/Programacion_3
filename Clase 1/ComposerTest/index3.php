<?php

require_once __DIR__ . '/vendor/autoload.php';

use NNV\RestCountries;

$restCountries = new RestCountries;

//$paises = $restCountries->all();

$paises = $restCountries->byRegion("asia");

print(json_encode($paises));


/*use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');*/
?>