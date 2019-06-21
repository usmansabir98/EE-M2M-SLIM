<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 19/12/2016
 * Time: 17:15
 */
$f_dir = __DIR__ . '\..\\';

include_once($f_dir . 'classes\DataStoreModel.php');
include_once($f_dir . 'wrappers\MySQL_Wrapper.php');

class DataStoreModelTest extends PHPUnit_Framework_TestCase
{
    protected $c_message = array(0=>array(
                    'SOURCEMSISDN' => 447817814149,
                    'DESTINATIONMSISDN' => 447817814149,
                    'RECEIVEDTIME' =>'2016-12-19 23:03:02',
                    'BEARER' => 'SMS',
                    'MESSAGEREF' => 0,
                    'ID' => '16-3110-AH',
                    'S1' => 1,
                    'S2' => 0,
                    'S3' => 0,
                    'S4' => 0,
                    'FAN' => 1,
                    'FRW' => 1,
                    'REV' => 0,
                    'H' => 0,
                    'TEMP' => 0,
                    'KEY' => 10));
    protected $c_message2 = array(0=>array(
        'SOURCEMSISDN' => 447817814149,
        'DESTINATIONMSISDN' => 447817814149,
        'RECEIVEDTIME' =>'18/12/2016 21:42:41',
        'BEARER' => 'SMS',
        'MESSAGEREF' => 0,
        'ID' => 'group1',
        'S1' => 1,
        'S2' => 0,
        'S3' => 0,
        'S4' => 0,
        'FAN' => 1,
        'FRW' => 1,
        'REV' => 0,
        'H' => 0,
        'TEMP' => 0,
        'KEY' => 10));

    function testMessageStoredNew() {

        $f_obj_store_handle = new DataStoreModel();
        $f_obj_mySQL = new MySQL_Wrapper();
        $f_obj_mySQL->connect_to_database();
        $f_obj_store_handle->set_database_handle($f_obj_mySQL);
        $f_obj_store_handle->do_get_database_connection_result();
        $f_obj_store_handle->set_downloaded_message_data($this->c_message);


        $this->assertTrue( $f_obj_store_handle->do_store_downloaded_message_data());
    }
    function testMessageStoredPresent() {

        $f_obj_store_handle = new DataStoreModel();
        $f_obj_mySQL = new MySQL_Wrapper();
        $f_obj_mySQL->connect_to_database();
        $f_obj_store_handle->set_database_handle($f_obj_mySQL);
        $f_obj_store_handle->do_get_database_connection_result();
        $f_obj_store_handle->set_downloaded_message_data($this->c_message2);


        $this->assertTrue( !$f_obj_store_handle->do_store_downloaded_message_data());
    }




}
