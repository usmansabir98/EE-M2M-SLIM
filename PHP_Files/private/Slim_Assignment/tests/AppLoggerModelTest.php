<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 30/12/2016
 * Time: 15:59
 */
$f_dir = __DIR__ . '\..\\';
include_once($f_dir . 'classes\AppLoggerModel.php');
include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
class AppLoggerModelTest extends PHPUnit_Framework_TestCase
{
    function test_do_logging_unexisting_user() {

        $f_obj_wrapper_db = new MySQL_Wrapper();
        $f_obj_logger_handle = new AppLoggerModel();


        $f_obj_wrapper_db->connect_to_database();
        $f_obj_logger_handle->set_database_handle($f_obj_wrapper_db);
        $f_obj_logger_handle->do_get_database_connection_result();


        $this->assertFalse( $f_obj_logger_handle->do_logging('notexists','no user existing'));
    }

    function test_do_logging_existing_user() {

        $f_obj_wrapper_db = new MySQL_Wrapper();
        $f_obj_logger_handle = new AppLoggerModel();


        $f_obj_wrapper_db->connect_to_database();
        $f_obj_logger_handle->set_database_handle($f_obj_wrapper_db);
        $f_obj_logger_handle->do_get_database_connection_result();


        $this->assertTrue( $f_obj_logger_handle->do_logging('test','user existing'));
    }

}
