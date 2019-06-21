<?php

  class SessionWrapperTest extends PHPUnit_Framework_Testcase {

    function testSetSession() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\Session_Wrapper.php');

      $f_obj_session_wrapper = new Session_Wrapper();

      $f_boolean_value = false;

      if($f_obj_session_wrapper->set_session('test', 'testing_value')) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetSession() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\Session_Wrapper.php');

      $f_obj_session_wrapper = new Session_Wrapper();

      $f_boolean_value = false;

      $f_obj_session_wrapper->set_session('test', 'testing_value');

      if($f_obj_session_wrapper->get_session('test')) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testUnsetSession() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\Session_Wrapper.php');

      $f_obj_session_wrapper = new Session_Wrapper();

      $f_boolean_value = false;

      $f_obj_session_wrapper->set_session('test', 'testing_value');

      if($f_obj_session_wrapper->unset_session('test')) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

  }
