<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 19/12/2016
 * Time: 14:01
 */
$f_dir = __DIR__ . '\..\\';

include_once($f_dir . 'classes\DataDownloadModel.php');
include_once($f_dir . 'wrappers\Soap_Wrapper.php');

class DataDownloadModelTest extends PHPUnit_Framework_TestCase
{
    function testMessageEmpty() {

        $f_obj_download_handle = new DataDownloadModel();

        $this->assertTrue( empty($f_obj_download_handle->get_downloaded_message_data()));
    }

    function testMessageNotEmpty() {

        $f_obj_download_handle = new DataDownloadModel();
        $f_obj_soap_wrapper= new Soap_Wrapper();
        $f_obj_soap_wrapper->set_wsdl('https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl');
        $f_obj_soap_wrapper->make_soap_client();
        $f_obj_soap_handle=$f_obj_soap_wrapper->get_soap_client_handle();
        $f_obj_download_handle->set_soap_client_handle($f_obj_soap_handle);
        $f_obj_download_handle->set_message_id(-1);
        $f_obj_download_handle->do_download_message();


        $this->assertTrue( !empty($f_obj_download_handle->get_downloaded_message_data()));
    }

    function testErrorPresentFalse() {

        $f_obj_download_handle = new DataDownloadModel();
        $this->assertTrue( !$f_obj_download_handle->do_error_exist());
    }

    function testSetDownloadMessageData(){
        $f_obj_download_handle = new DataDownloadModel();
        $f_obj_download_handle->set_downloaded_message_data(array('a'=>1,'b'=>2));
        $this->assertTrue( !empty($f_obj_download_handle->get_downloaded_message_data()));
    }
}
