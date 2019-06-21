<?php

  class MySQLWrapperTest extends PHPUnit_Framework_Testcase {

    function testConnectToDB() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');

      $f_obj_mysql_wrapper = new MySQL_Wrapper();

      $f_boolean_value = false;

      if($f_obj_mysql_wrapper->connect_to_database()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testSafQuery() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();

      $f_boolean_value = false;
      if($f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null)) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testCountRows() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();
      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null);
      $f_number_of_rows = $f_obj_wrapper_db->count_rows();

      $f_returned_rows = false;

      if($f_number_of_rows > 0) {
        $f_returned_rows = true;
      }

      $this->assertEquals(true, $f_returned_rows);

    }

    function testCountColumns() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();
      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null);
      $f_number_of_columns = $f_obj_wrapper_db->count_columns();

      $f_returned_columns = false;

      if($f_number_of_columns > 0) {
        $f_returned_columns = true;
      }

      $this->assertEquals(true, $f_returned_columns);

    }

    function testFetchAll() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();
      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null);
      $f_number_of_rows = $f_obj_wrapper_db->fetch_All();

      $f_returned_rows = false;

      if($f_number_of_rows > 0) {
        $f_returned_rows = true;
      }

      $this->assertEquals(true, $f_returned_rows);

    }

    function testSafeFetchRow() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();
      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null);
      $f_number_of_rows = $f_obj_wrapper_db->safe_fetch_row();

      $f_returned_rows = false;

      if($f_number_of_rows > 0) {
        $f_returned_rows = true;
      }

      $this->assertEquals(true, $f_returned_rows);

    }

    function testSafeFetchArray() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MySQL_Wrapper.php');
      include_once($f_dir . 'wrappers\SQL_Wrapper.php');

      $f_obj_wrapper_sql = new SQL_Wrapper();
      $f_obj_wrapper_db = new MySQL_Wrapper();

      $f_obj_wrapper_db->connect_to_database();
      $f_obj_wrapper_db->safe_query($f_obj_wrapper_sql->get_admin_id(), null);
      $f_number_of_array = $f_obj_wrapper_db->safe_fetch_array();

      $f_returned_array = false;

      if($f_number_of_array > 0) {
        $f_returned_array = true;
      }

      $this->assertEquals(true, $f_returned_array);

    }

  }
