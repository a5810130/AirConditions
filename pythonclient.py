import time
from zeep import Client
import xml.etree.ElementTree as ET
from lxml import etree


client = Client('http://localhost/airconditions/server.php?wsdl')

# InsertAirInfo
# client.service.InsertAirInfo(room = "400",unixtime = 17775,temperature = 25.9,humidity = 55.5)

# GetStudentInfo
# res = client.service.GetStudentInfo()
# res = client.create_message(client.service, 'GetStudentInfo')
#     # Validate schema
# xsd_tree = etree.parse("http://localhost/AirConditions/Students.xsd")
# xml_root = etree.XML(res.encode('utf-8'))
# schema = etree.XMLSchema(xsd_tree)
# print(schema.validate(xml_root))
# out = (etree.tostring(xml_root)).decode('utf-8')
# print(out)

# InsertTask
client.service.InsertTask(name="Bob", address="72/3 Bangkok", weight=5.2)
# TaskDelivered
client.service.TaskDelivered(id=5);








