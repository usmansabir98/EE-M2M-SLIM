<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 19/12/2016
 * Time: 12:28
 */
$f_dir = __DIR__ . '\..\\';
include_once($f_dir . 'classes\DataDisplayModel.php');
include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
class DataDisplayModelTest extends PHPUnit_Framework_TestCase
{
    function testMessageStoredEmpty() {

        $f_obj_display_handle = new DataDisplayModel();

        $this->assertTrue( empty($f_obj_display_handle->get_stored_message_data()));
    }

    function testMessageStoredPresent() {

        $f_obj_wrapper_db = new MySQL_Wrapper();
        $f_obj_display_handle = new DataDisplayModel();


        $f_obj_wrapper_db->connect_to_database();
        $f_obj_display_handle->set_database_handle($f_obj_wrapper_db);
        $f_obj_display_handle->set_message_id(-1);
        $f_obj_display_handle->do_get_database_connection_result();
        $f_obj_display_handle->do_retrieve_stored_message_data();

        $this->assertTrue( !empty($f_obj_display_handle->get_stored_message_data()));
    }

    function testErrorPresentFalse() {

        $f_obj_display_handle = new DataDisplayModel();
        $this->assertTrue( !$f_obj_display_handle->do_error_exist());
    }

    function testMetadataPresent() {

        $f_obj_wrapper_db = new MySQL_Wrapper();
        $f_obj_display_handle = new DataDisplayModel();


        $f_obj_wrapper_db->connect_to_database();
        $f_obj_display_handle->set_database_handle($f_obj_wrapper_db);
        $f_obj_display_handle->set_message_id(-1);
        $f_obj_display_handle->do_get_database_connection_result();
        $f_obj_display_handle->do_retrieve_metadata();

        $this->assertTrue( !empty($f_obj_display_handle->get_metadata()));
    }



}
