<?php

  class HTMLWrapperTest extends PHPUnit_Framework_Testcase {

    function testGetHeader() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_header()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetAuthenticationPageForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_authentication_page_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetLoginForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_login_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetRegisterForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_register_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetHomePageForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_homepage_page_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetHomePageErrorForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_homepage_page_error_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetDownloadPage() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_download_page()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetReviewPage() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_review_page()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetLoginInputErrorForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_login_input_field_empty_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetLoginWrongInputErrorForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_login_wrong_input_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetRegisterInputErrorForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_register_input_field_empty_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetRegisterUserExistsForm() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;

      if($f_obj_html_wrapper->get_register_user_exists_form()) {
        $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testDoDisplayProcessing() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;
      $f_obj_html_wrapper->do_display_page_processing(array('test' => 'test'), array('0' => array('test' => 'test')));
      $f_boolean_value = true;

      $this->assertEquals(true, $f_boolean_value);

    }

    function testGetDisplayProcessed() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\HTML_Wrapper.php');

      $f_obj_html_wrapper = new HTML_Wrapper();

      $f_boolean_value = false;
      $f_obj_html_wrapper->do_display_page_processing(array('test' => 'test'), array('0' => array('test' => 'test')));

      if($f_obj_html_wrapper->get_display_page_processed()) {
          $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

  }
