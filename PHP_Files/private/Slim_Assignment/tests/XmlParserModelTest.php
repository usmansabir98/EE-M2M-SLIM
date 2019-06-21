<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 20/12/2016
 * Time: 11:19
 */

$f_dir = __DIR__ . '\..\\';
include_once($f_dir . 'classes\XMLparserModel.php');

class XmlParserModelTest extends PHPUnit_Framework_TestCase
{
    protected $c_xml_string='<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>19/12/2016 22:03:02</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><id>16-3110-AH</id><s1>1</s1><s2>0</s2><s3>0</s3><s4>0</s4><fan>1</fan><frw>1</frw><rev>0</rev><h>0</h><temp>0</temp><key>10</key></message></messagerx>';

    protected $c_message = array(
        'SOURCEMSISDN' => '447817814149',
        'DESTINATIONMSISDN' => '447817814149',
        'RECEIVEDTIME' =>'19/12/2016 22:03:02',
        'BEARER' => 'SMS',
        'MESSAGEREF' => '0',
        'ID' => '16-3110-AH',
        'S1' => '1',
        'S2' => '0',
        'S3' => '0',
        'S4' => '0',
        'FAN' => '1',
        'FRW' => '1',
        'REV' => '0',
        'H' => '0',
        'TEMP' => '0',
        'KEY' => '10');

    public function testXMLParsingCorrect(){
        $f_obj_xml=new XmlParserModel();
        $f_obj_xml->set_xml_string_to_parse($this->c_xml_string);
        $f_obj_xml->do_parse_the_xml_string();
        $this->assertEquals($this->c_message,$f_obj_xml->get_parsed_message_data());


    }

}
