<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new Zend\Soap\Client('http://localhost/airconditions/server.php?wsdl');

// InsertAirInfo
//$result = $client->InsertAirInfo(['room'=>482,'unixtime'=>time(), 'temperature'=>25, 'humidity'=> 35]);
// GetAirInfo
//$result = $client->GetAirInfo();
//echo $result->GetAirInfoResult;

// GetStudentInfo
// $result = $client->GetStudentInfo();
// echo $result->GetStudentInfoResult;
// $xml= new DOMDocument();
// $xml->loadXML($result->GetStudentInfoResult);
// if($xml->schemaValidate('http://localhost/AirConditions/Students.xsd')){
//     echo "XML Validated";
// }

// InsertTask
// $client->InsertTask(['name'=>'nitikarn','address'=>'kmutnb', 'weight'=>12.5]);
// TaskDelivered
// $client->TaskDelivered(['id'=>3]);

// GetTask
$result = $client->GetTask();
echo $result->GetTaskResult;
?>
