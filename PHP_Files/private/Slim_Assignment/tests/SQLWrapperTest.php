<?php

  class SQLWrapperTest extends PHPUnit_Framework_Testcase {

    function testGetAdminID() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null);
      $m_number_of_rows = $f_obj_wrapper_db->fetch_All();

      $f_returned_rows = false;

      if($m_number_of_rows > 0) {
        $f_returned_rows = true;
      }

      $this->assertEquals(true, $f_returned_rows);

    }

    function testGetAdminCredintials() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_credintials(), null);
      $m_number_of_rows = $f_obj_wrapper_db->fetch_All();

      $f_returned_rows = false;

      if($m_number_of_rows > 0) {
        $f_returned_rows = true;
      }

      $this->assertEquals(true, $f_returned_rows);

    }

    function testGetStoredUsernameAndEmail() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_stored_username_and_email(), null);
      $m_number_of_rows = $f_obj_wrapper_db->fetch_All();

      $f_returned_rows = false;

      if($m_number_of_rows > 0) {
        $f_returned_rows = true;
      }

      $this->assertEquals(true, $f_returned_rows);

    }

    function testSetUserCredintials() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $m_arr_sql_query_parameters = array(':ID' => 100, ':Username' => 'test', ':Password' => 12345, ':Email' => 'test@gmail.com');

      $f_boolean_set_user = false;

      if($f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->set_user_credintials(), $m_arr_sql_query_parameters)) {
        $f_boolean_set_user = true;
      }

      $this->assertEquals(true, $f_boolean_set_user);

    }

    function testStoreMessages() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $m_arr_sql_query_parameters = array(':SOURCEMSISDN' => 1, ':DESTINATIONMSISDN' => 1, ':RECEIVEDTIME' => 20161001101010,
                                      ':BEARER' => 'test', ':MESSAGEREF' => 'test', ':ID' => 'test', ':S1' => 1, ':S2' => 1, ':S3' => 1, ':S4' => 1,
                                      ':FAN' => 1, ':FRW' => 1, ':REV' => 1, ':H' => 1, ':TEMP' => 1, ':KEY' => 1);

      $f_boolean_set_user = false;

      if($f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->store_message(), $m_arr_sql_query_parameters)) {
        $f_boolean_set_user = true;
      }

      $this->assertEquals(true, $f_boolean_set_user);

    }

    function testCheckMessageExists() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $m_arr_sql_query_parameters = array(':sourceMSISDN' => '447817814149', ':receivedDate' => '2016-12-13 11:24:13');
      $m_number_of_rows = $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->check_message_exist(), $m_arr_sql_query_parameters);

      $f_boolean_message_exist = false;

      if($m_number_of_rows > 0) {
        $f_boolean_message_exist = true;
      }

      $this->assertEquals(true, $f_boolean_message_exist);

    }

    function testGetMessageData() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $m_arr_sql_query_parameters = array(':sourceMSISDN' => '447817814149');
      $m_number_of_rows = $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_message_data(), $m_arr_sql_query_parameters);

      $f_boolean_message_exist = false;

      if($m_number_of_rows > 0) {
        $f_boolean_message_exist = true;
      }

      $this->assertEquals(true, $f_boolean_message_exist);

    }

    function testGetMetaData() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $m_number_of_rows = $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_metadata(), null);

      $f_boolean_message_exist = false;

      if($m_number_of_rows > 0) {
        $f_boolean_message_exist = true;
      }

      $this->assertEquals(true, $f_boolean_message_exist);

    }

  }
