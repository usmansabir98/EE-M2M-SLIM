<?php

  class MySQLWrapperTest extends PHPUnit_Framework_Testcase {

    function testInitialiseEncryption() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MCrypt_Wrapper.php');

      $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();

      $f_boolean_value = false;

      $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();
      $f_boolean_value = true;

      $this->assertEquals(true, $f_boolean_value);

    }

    function testEncrypt() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MCrypt_Wrapper.php');

      $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();

      $f_boolean_value = false;

      $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();

      if($f_obj_mcrypt_wrapper->encrypt('test')) {
          $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

    function testDecrypt() {

      $f_dir = __DIR__ . '\..\\';

      include_once($f_dir . 'wrappers\MCrypt_Wrapper.php');

      $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();

      $f_boolean_value = false;

      $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();

      if($f_obj_mcrypt_wrapper->decrypt($f_obj_mcrypt_wrapper->encrypt('test'))) {
          $f_boolean_value = true;
      }

      $this->assertEquals(true, $f_boolean_value);

    }

  }
