<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * Session_Wrapper.php
 *
 * Here the Session_Wrapper acts as a container. Instead of calling
 * sessions directly for each instance, parameters can be passed to the methods
 * defined below, which will automatically set, get or unset the sessions securely.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk> - Modified by Users: P14184295 and P14166609
 * @copyright De Montfort University
 */

//  Returns path : .... PHP_Files\private\Slim_Assignment/wrappers\
 $f_wrapper_path = $app->config('wrappers.path') . DIRSEP;
 require_once $f_wrapper_path . 'OpenSSL_Wrapper.php';

include_once(__DIR__ . '/../wrappers/OpenSSL_Wrapper.php');  //Switched to include_once()!

class Session_Wrapper
{
	public function __construct() { }

	public function __destruct() { }

  /**
   * set_session($p_session_key, $p_session_value_to_set) sets the current session for the
   * value passed to the method.
   *
   * @param - $p_session_key - is the Key name to be set
   * @param - $p_session_value_to_set - is the value that is to be along with the Key name that defines the value
   * @return - returns the current state of the session, indicating whether the session has been set or not
   */

	public static function set_session($p_session_key, $p_session_value_to_set)
	{
		$m_session_value_set_successfully = false;              //current state of the session not being set
		if (!empty($p_session_value_to_set))                    //checks if value passed is empty/not
		{

      /*
       * If value not empty then the call to the OpenSSL_Wrapper is
       * which initialises the encyption and sets the current key/value pairs in a encrypted manner.
       */

				$f_obj_openssl_wrapper = new OpenSSLEncr();

			$_SESSION[$p_session_key] = $f_obj_openssl_wrapper->encrypt($p_session_value_to_set);
			// $_SESSION[$p_session_key] = $p_session_value_to_set;

      /*
       * If the value stored within the session matches the value passed as a parameter than the
       * session has been set properly else return as false indicating failure.
       */

			if (strcmp($f_obj_openssl_wrapper->decrypt($_SESSION[$p_session_key]), $p_session_value_to_set) == 0)
			{
				$m_session_value_set_successfully = true;
			}
			if (strcmp($_SESSION[$p_session_key], $p_session_value_to_set) == 0)
			{
				$m_session_value_set_successfully = true;
			}
		}
		return $m_session_value_set_successfully;
	}

  /**
   * get_session($p_session_key) gets the current session.
   *
   * @param - $p_session_key - is the Key name to be get
   * @return - returns the current state of the session given by the session key
   */

	public static function get_session($p_session_key)
	{
		$m_session_value = false;                       //current session value is false
		if (isset($_SESSION[$p_session_key]))           //if the parameter value is set as a session than session value is returned
		{                                               //else false is returned
			$m_session_value = $_SESSION[$p_session_key];
		}
		return $m_session_value;
	}

  /**
   * unset_session($p_session_key) unsets the current session.
   *
   * @param - $p_session_key - is the Key name to be get
   * @return - returns the value true/false which will indicate the nature of the session state
   */

	public static function unset_session($p_session_key)
	{
		$m_unset_session = false;                    //current value is false
		if (isset($_SESSION[$p_session_key]))        //if session is set for the parameter key passed
		{                                            //then unset the session otherwise if it is not set then
			unset($_SESSION[$p_session_key]);          //the current value is true. Return value
		}
		if (!isset($_SESSION[$p_session_key]))
		{
			$m_unset_session = true;
		}
		return $m_unset_session;
	}
}
