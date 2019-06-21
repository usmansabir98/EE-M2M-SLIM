<?php

$f_dir = __DIR__ . '\..\\';

include_once($f_dir . 'classes\LoginModel.php');
include_once($f_dir . 'wrappers\MySQL_Wrapper.php');


class LoginModelTest extends PHPUnit_Framework_Testcase {

    function testLoginWrongCredentials() {

      $f_obj_wrapper_db = new MySQL_Wrapper();
      $f_obj_login_handle = new LoginModel();

      $f_obj_wrapper_db->connect_to_database();
      $f_obj_login_handle->set_database_handle($f_obj_wrapper_db);
      $f_obj_login_handle->do_get_database_connection_result();
      $f_obj_login_handle->set_admin_credintials('test3','test');

      $this->assertTrue(!$f_obj_login_handle->do_admin_credintials());
    }

      function testLoginCorrectCredentials() {

          $f_obj_wrapper_db = new MySQL_Wrapper();
          $f_obj_login_handle = new LoginModel();

          $f_obj_wrapper_db->connect_to_database();
          $f_obj_login_handle->set_database_handle($f_obj_wrapper_db);
          $f_obj_login_handle->do_get_database_connection_result();
          $f_obj_login_handle->set_admin_credintials('test','test');

          $this->assertTrue($f_obj_login_handle->do_admin_credintials());
      }

      function testErrorsPresence0() {

          $f_obj_wrapper_db = new MySQL_Wrapper();
          $f_obj_login_handle = new LoginModel();

          $f_obj_wrapper_db->connect_to_database();
          $f_obj_login_handle->set_database_handle($f_obj_wrapper_db);
          $f_obj_login_handle->do_get_database_connection_result();
          $f_obj_login_handle->set_admin_credintials('test3','test');

          $this->assertFalse($f_obj_login_handle->do_error_exist());
      }

  }
