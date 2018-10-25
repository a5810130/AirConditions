<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new Zend\Soap\Client('http://localhost/airconditions/server.php?wsdl');
//$result = $client->InsertAirInfo(['room'=>482,'unixtime'=>time(), 'temperature'=>25, 'humidity'=> 35]);

//$result = $client->GetAirInfo();
//echo $result->GetAirInfoResult;

$result = $client->GetStudentInfo();
echo $result->GetStudentInfoResult;

$xml= new DOMDocument();
$xml->loadXML($result->GetStudentInfoResult);
if($xml->schemaValidate('http://localhost/AirConditions/Students.xsd')){
    echo "XML Validated";
}
?>
