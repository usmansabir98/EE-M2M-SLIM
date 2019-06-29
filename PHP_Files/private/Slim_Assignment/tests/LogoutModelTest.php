<?php


$f_dir = __DIR__ . '\..\\';

include_once($f_dir . 'classes\LogoutModel.php');
include_once($f_dir . 'wrappers\Session_Wrapper.php');


class LogoutModelTest extends PHPUnit_Framework_TestCase
{
    function testLogout() {

        $f_obj_wrapper_session = new Session_Wrapper();
        $f_obj_logout_handle = new LogoutModel();
        $f_obj_wrapper_session::set_session('username','testing');
        $f_obj_wrapper_session::set_session('password','testing1');


        $this->assertTrue($f_obj_logout_handle->do_logout());

    }
}
