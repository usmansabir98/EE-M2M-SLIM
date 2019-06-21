<?php

$f_dir = __DIR__ . '\..\\';
include_once($f_dir . 'wrappers\Soap_Wrapper.php');

  class SoapWrapperTest extends PHPUnit_Framework_Testcase {
      protected  $c_wsdl='https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';

      public function testSoapConnection(){
          $f_obj_soap=new Soap_Wrapper();
          $f_obj_soap->set_wsdl($this->c_wsdl);
          $this->assertFalse($f_obj_soap->make_soap_client());
      }

      public function testSoapConnectionError(){
          $f_obj_soap=new Soap_Wrapper();
          $f_obj_soap->set_wsdl(null);
          $this->assertTrue($f_obj_soap->make_soap_client());
      }
  }
