<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 19/12/2016
 * Time: 18:58
 */
$f_dir = __DIR__ . '\..\\';

include_once($f_dir . 'classes\SessionModel.php');
include_once($f_dir . 'wrappers\Session_Wrapper.php');


class SessionModelTest extends PHPUnit_Framework_TestCase
{

    function testSessionStorage() {

        $f_obj_wrapper_session = new Session_Wrapper();
        $f_obj_session_handle = new SessionModel();

        $f_obj_session_handle->set_wrapper_session($f_obj_wrapper_session);
        $f_obj_session_handle->set_session_values('test123','test123');
        $f_obj_session_handle->do_storage();
        $this->assertTrue($f_obj_session_handle->get_storage_result());
    }
}
