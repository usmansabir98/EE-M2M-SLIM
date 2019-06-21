<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 28/11/2016
 *
 * ValidateModel.php
 *
 * Here the Validate Model can be reused for handling any user information,
 * this class validates and sanitises all inputs retrieved from the fields.
 * It also hides any important details from being handled else where and provides
 * functions to handle any incoming user information, returning reliable results.
 *
 * It uses different sanitisation and validation techniques to filter out incoming data
 *
 * @author CF Ingrams <cfi@dmu.ac.uk> - Modified by Users: P14184295 and P14166609
 * @copyright De Montfort University
 */


 class ValidateModel
 {
	 public function __construct() { }

	 public function __destruct() { }

   /**
    * sanitise_string($p_string_to_sanitise) gets the input value and checks it against
    * the settings within this method to sanitise the string and return the filtered output.
    *
    * @param - $p_string_to_sanitise - string that needs sanitising
    * @return - returns a boolean indicating string sanitisation success/failure
    */

	 public function sanitise_string($p_string_to_sanitise)
	 {
		 $m_sanitised_string = false;                                         //current value false, indicating string not sanitised
		 $m_maximum_string_length = 255;                                      //max length of string has to be under or 255
		 if (!empty($p_string_to_sanitise))                                   //if string is not empty and under or equal to 255 it gets sanitised
		 {
			 if (strlen($p_string_to_sanitise) <= $m_maximum_string_length)     //a value is returned when the string has/has not been sanitised, indicating success/failure of string sanitisation
			 {
				 $m_sanitised_string = filter_var($p_string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			 }
		 }
		 return $m_sanitised_string;
	 }

   /**
    * validate_string($p_value_to_check) validates the incoming string to a specific
    * format, validates the string to the correct format else returns error.
    *
    * @param - $p_value_to_check - string that needs validating
    * @return - returns a boolean indicating string validating success/failure
    */

	 public function validate_string($p_value_to_check)
	 {
		 $m_checked_bool_aplnum = false;                                //value indicates string has not yet been validated

		 if (isset($p_value_to_check))                                  //if string is set then the validation checks the string, the string should only contain alphnumeric
		 {
			 $m_checked_bool_aplnum = ctype_alnum($p_value_to_check);
		 }
		 return $m_checked_bool_aplnum;                                 //returns value indicating success/failure of string validation
	 }

   /**
    * validate_email($p_value_to_check) validates the incoming email to a specific
    * format, validates the email to the correct format else returns error.
    *
    * @param - $p_value_to_check - email that needs validating
    * @return - returns a boolean indicating email validating success/failure
    */

   public function validate_email($p_value_to_check)
	 {
		 $m_checked_bool_aplnum = false;                              //email has not yet been validated

		 if (isset($p_value_to_check) && filter_var($p_value_to_check, FILTER_VALIDATE_EMAIL))    //if string is set then filter, if all successful then email is validated else failure
		 {
			  $m_checked_bool_aplnum = true;
		 }
		 return $m_checked_bool_aplnum;
	 }



   /**
    * validate_feature($p_type_to_check) validates the incoming feature within a range
    * validating the faeture to the correct format else returns error.
    *
    * @param - $p_value_to_check - feature that needs validating
    * @return - returns a boolean indicating feature validating success/failure
    */

	 public function validate_feature($p_type_to_check)
	 {
		 $m_checked_server_type = false;                                                                //feature not yet validated
		 $m_arr_calculation_type = array('login', 'register', 'download_ee_form', 'review_ee_form');    //feature checked against this array
		 if (in_array($p_type_to_check, $m_arr_calculation_type))                                       //if feature in array then it is validated else not validated
		 {
			 $m_checked_server_type = $p_type_to_check;
		 }
		 return $m_checked_server_type;
	 }

   /**
    * validate_size($p_array_to_check) validates the incoming array within a range
    * validating the faeture to the correct format else returns error.
    *
    * @param - $p_array_to_check - array that needs validating
    * @return - returns a validated array
    */

   public function validate_size($p_array_to_check)
   {
       $m_checked_array=array();                                                        //array will store validated items
       $m_keys_array = array('SOURCEMSISDN','DESTINATIONMSISDN','RECEIVEDTIME',         //keys to check against incoming array for validation
           'BEARER','MESSAGEREF','ID',
           'S1','S2','S3','S4',
           'FAN','FRW','REV',
           'H','TEMP','KEY');

       foreach ($p_array_to_check as $key => $value)                                   //if the values matches then success else failure
       {

           if(sizeof($value)==16 && count(array_intersect_key(array_flip($m_keys_array), $value)) === count($m_keys_array))
           {

               $m_checked_array[]=$p_array_to_check[$key];
           }
       }



       return $m_checked_array;
   }

   /**
    * validate_phone($p_phone_to_validate) validates the incoming phone number
    * to a specific set of characters
    *
    * @param - $p_phone_to_validate - phone number that needs validating
    * @return - returns a validated phonen number
    */

   public function validate_phone($p_phone_to_validate)
   {
       $options = array(                                                                          //regex array, phone number to be compared against regex
           'options' => array(
               'regexp'=>'~^\d{12}$~'));
       $m_validated_phone = filter_var($p_phone_to_validate, FILTER_VALIDATE_REGEXP,$options);    //value is validated and if sucess then it is validated else failure
       return $m_validated_phone;
   }

   /**
    * validate_array_message($p_array_to_check) validates the incoming array messages
    * against set of characters
    *
    * @param - $p_array_to_check - array that needs validating
    * @return - returns a validated array of messages
    */

   public function validate_array_message($p_array_to_check)
   {
       $m_checked_array = array();                                                              //empty array stores checked values
       $m_args= array(                                                                          //compares against these values and regex
           'SOURCEMSISDN' => FILTER_SANITIZE_STRING,
           'DESTINATIONMSISDN' => FILTER_SANITIZE_STRING,
           'RECEIVEDTIME' =>array('filter'=>FILTER_VALIDATE_REGEXP,
               'options'=>array(
                   'regexp'=>'~^\d{2}\/\d{2}\/\d{4}\040\d{2}\:\d{2}\:\d{2}$~'
               )),
           'BEARER' => FILTER_SANITIZE_STRING,
           'MESSAGEREF' => FILTER_VALIDATE_INT,
            'ID' => FILTER_SANITIZE_STRING,
           'S1' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'S2' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'S3' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'S4' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'FAN' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'FRW' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'REV' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'H' => array('filter'=>FILTER_VALIDATE_INT,
               'options'=>array(
                   'default'=>-1,
                   'min_range' => 0,
                   'max_range' => 1
               )),
           'TEMP' => FILTER_VALIDATE_FLOAT,
           'KEY' => FILTER_VALIDATE_INT
       );

       foreach ($p_array_to_check as $key => $value)                                           //for each value, it gets validated if success return else failure return
       {
           $m_result=filter_var_array($value,$m_args);
           if(!(in_array(false,$m_result,true)|| in_array(-1,$m_result)))
           {
               $m_checked_array[]=$m_result;
           }
       }


       return $m_checked_array;
   }
 }
