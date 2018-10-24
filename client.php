<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new Zend\Soap\Client('http://localhost/aircondition/server.php?wsdl');
$result = $client->InsertAirInfo(['room'=>481,'unixtime'=>time(), 'temperature'=>25, 'humidity'=> 35]);

//$result = $client->GetAirInfo();
//echo $result->GetAirInfoResult;

?>
