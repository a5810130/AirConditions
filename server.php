<?php

require_once __DIR__ . '/vendor/autoload.php';

class AirCondition
{
  /**
  *  @return object
  */
  public function GetAirInfo()
  {
    $xml=simplexml_load_file("http://localhost/AirCondition/AirCondition.xml");
    return ($xml->asXML());
  }
  
  /**
  *  @param string  $room 
  *  @param integer $unixtime
  *  @param double  $temperature 
  *  @param double  $humidity
  */
  public function InsertAirInfo($room=false,$unixtime=false,$temperature=false,$humidity=false)
  {
	if(!$unixtime) $unixtime = time();
	if(!$temperature or !$humidity) return ;
	$xml=simplexml_load_file("http://localhost/AirCondition/AirCondition.xml");
	$aircon = $xml->addChild("AirCondition");
	$aircon->addChild("room",$room);
	$aircon->addChild("unixtime",$unixtime);
	$aircon->addChild("temperature",$temperature);
	$aircon->addChild("humidity",$humidity);
	
	$doc = new DOMDocument();
	$doc->preserveWhiteSpace = false;
	$doc->formatOutput = true;
	$doc->loadXML($xml->asXML());
	$doc->save('AirCondition.xml');
  }
}

$serverUrl = "http://localhost/AirCondition/server.php";
$options = [
    'uri' => $serverUrl,
];
$server = new Zend\Soap\Server(null, $options);


if (isset($_GET['wsdl'])) {
    $soapAutoDiscover = new \Zend\Soap\AutoDiscover(new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence());
    $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
    $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
    $soapAutoDiscover->setClass('AirCondition');
    $soapAutoDiscover->setUri($serverUrl);

    header("Content-Type: text/xml");
    echo $soapAutoDiscover->generate()->toXml();
} else {
    $soap = new Zend\Soap\Server($serverUrl . '?wsdl');
    $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new AirCondition()));
    $soap->handle();
}
?>
