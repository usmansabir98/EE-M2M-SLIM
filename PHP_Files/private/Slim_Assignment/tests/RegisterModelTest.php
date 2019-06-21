<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 19/12/2016
 * Time: 18:17
 */
$f_dir = __DIR__ . '\..\\';

include_once($f_dir . 'classes\RegisterModel.php');
include_once($f_dir . 'wrappers\MySQL_Wrapper.php');


class RegisterModelTest extends PHPUnit_Framework_TestCase
{
    protected $c_user='test';
    protected $c_password='test';
    protected $c_email='test@test.it';

    protected $c_user1='test3';
    protected $c_password1='test3';
    protected $c_email1='test3@test.it';

    function testRegisterAlredyRegistered() {

        $f_obj_wrapper_db = new MySQL_Wrapper();
        $f_obj_register_handle = new RegisterModel();

        $f_obj_wrapper_db->connect_to_database();
        $f_obj_register_handle->set_database_handle($f_obj_wrapper_db);
        $f_obj_register_handle->do_get_database_connection_result();
        $f_obj_register_handle->set_user_credintials($this->c_user,$this->c_password,$this->c_email);



        $this->assertFalse($f_obj_register_handle->get_user_credintials());
    }

    function testRegisterNew() {

        $f_obj_wrapper_db = new MySQL_Wrapper();
        $f_obj_register_handle = new RegisterModel();

        $f_obj_wrapper_db->connect_to_database();
        $f_obj_register_handle->set_database_handle($f_obj_wrapper_db);
        $f_obj_register_handle->do_get_database_connection_result();
        $f_obj_register_handle->set_user_credintials($this->c_user1,$this->c_password1,$this->c_email1);


        $this->assertTrue($f_obj_register_handle->get_user_credintials());
    }
}
