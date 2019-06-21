<?php

/**
 * Created by PhpStorm.
 * User: Rajatt
 * Date: 19/12/2016
 * Time: 19:18
 */

$f_dir = __DIR__ . '\..\\';
include_once($f_dir . 'classes\ValidateModel.php');

class ValidateModelTest extends PHPUnit_Framework_TestCase
{

    protected $c_message = array(0=>array(
        'SOURCEMSISDN' => 447817814149,
        'DESTINATIONMSISDN' => 447817814149,
        'RECEIVEDTIME' =>'19/12/2016 17:00:00',
        'BEARER' => 'SMS',
        'MESSAGEREF' => 0,
        'ID' => 'group1',
        'S1' => 1,
        'S2' => 0,
        'S3' => 0,
        'S4' => 0,
        'FAN' => 0,
        'FRW' => 0,
        'REV' => 0,
        'H' => 1,
        'TEMP' => 10.2,
        'KEY' => 9));
    protected $c_message2 = array(0=>array(
        'SOURCEMSISDN' => 447817814149,
        'DESTINATIONMSISDN' => 447817814149,
        'RECEIVEDTIME' =>'Mon 12 2006 21:41:41',
        'BEARER' => 'SMS',
        'MESSAGEREF' => 0,
        'ID' => 'group1',
        'S1' => 'a',
        'S2' => 0,
        'S3' => 0,
        'S4' => 0,
        'FAN' => 1,
        'FRW' => 1,
        'REV' => 0,
        'H' => 0,
        'TEMP' => 0,
        'KEY' => 10,
        'KEY2'=>11));

    function testSanitizeString(){

        $f_obj_validate = new ValidateModel();
        $string_to_sanitise='<script><h1>hello</h1><script>';
        $this->assertEquals('hello',$f_obj_validate->sanitise_string($string_to_sanitise));


    }

    function testValidateString(){
        $f_obj_validate = new ValidateModel();
        $string_to_validate='<script>test</script>';
        $this->assertFalse($f_obj_validate->validate_string($string_to_validate));
        $string_to_validate='test123,.';
        $this->assertFalse($f_obj_validate->validate_string($string_to_validate));
    }

    function testValidateEmail(){
        $f_obj_validate = new ValidateModel();
        $email_to_validate='<script>test</script>';
        $this->assertFalse($f_obj_validate->validate_email($email_to_validate));
        $email_to_validate='test123@mydmu.ac.uk';
        $this->assertTrue($f_obj_validate->validate_email($email_to_validate));
    }

    function testValidateFeature(){
        $f_obj_validate = new ValidateModel();
        $feature_to_validate='<script>test</script>';
        $this->assertFalse($f_obj_validate->validate_feature($feature_to_validate));
        $feature_to_validate='login';
        $this->assertEquals('login',$f_obj_validate->validate_feature($feature_to_validate));
    }

    function testValidateSize(){
        $f_obj_validate = new ValidateModel();
        $this->assertEquals($this->c_message,$f_obj_validate->validate_size($this->c_message));
        $this->assertTrue(empty($f_obj_validate->validate_size($this->c_message2)));
    }

    function testValidatePhone(){
        $f_obj_validate = new ValidateModel();
        $f_phone_to_validate='447817814149';
        $this->assertEquals('447817814149',$f_obj_validate->validate_phone($f_phone_to_validate));
        $f_phone_to_validate='4478178141419';
        $this->assertFalse($f_obj_validate->validate_phone($f_phone_to_validate));

    }

    function testValidateMessageArray(){
        $f_obj_validate = new ValidateModel();
        $this->assertEquals($this->c_message,$f_obj_validate->validate_array_message($this->c_message));
        $this->assertTrue(empty($f_obj_validate->validate_array_message($this->c_message2)));
    }



}
