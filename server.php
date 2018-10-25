<?php

require_once __DIR__ . '/vendor/autoload.php';

class AirCondition
{
  /**
  *  @return string
  */
  public function GetAirInfo()
  {
    $xml=simplexml_load_file("http://localhost/AirConditions/AirCondition.xml"); 
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
	$xml=simplexml_load_file("http://localhost/AirConditions/AirCondition.xml");
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

  /**
  *  @return string
  */
  public function GetStudentInfo()
  {
    $xml=simplexml_load_file("http://localhost/AirConditions/Students.xml"); 
    return ($xml->asXML());
  }

  /**
   * @param string  $name
   * @param string  $address
   * @param double  $weight
   */
  public function InsertTask($name,$address,$weight)
  {
    $xml=simplexml_load_file("http://localhost/AirConditions/DeliveryTasks.xml");
    if($last = $xml->Task[count($xml)-1])
        $id = $last->id+1;
    else $id = 1;
    $task = $xml->addChild("Task");
    $task->addChild("id",$id);
    $task->addChild("name",$name);
    $task->addChild("address",$address);
    $task->addChild("weight",$weight);
    $task->addChild("delivered","False");
    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;
    $doc->loadXML($xml->asXML());
    $doc->save('DeliveryTasks.xml');
    // return ($xml->asXML());
  }

  /**
   * @param int $id
   */
  public function TaskDelivered($id)
  {
    $xml=simplexml_load_file("http://localhost/AirConditions/DeliveryTasks.xml");
    foreach ($xml->children() as $item ){
      if ($item->id==$id)
          $item->delivered = "True";
    }
    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;
    $doc->loadXML($xml->asXML());
    $doc->save('DeliveryTasks.xml');
    // return ($xml->asXML());
  }

  /**
   * @return string 
   */
  public function GetTask()
  {
    $xml=simplexml_load_file("http://localhost/AirConditions/DeliveryTasks.xml");
    echo $xml->asXML();
  }  
}

$serverUrl = "http://localhost/AirConditions/server.php";
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
