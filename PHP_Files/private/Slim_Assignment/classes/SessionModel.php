<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * SessionModel1.php
 *
 * Here the Session Model can be reused for handling any user information.
 * It hides any important details from being handled else where and provides
 * functions to handle any incoming user information, returning reliable results.
 *
 * It uses the handles to require an appropriate session wrapper which is used within
 * the getter and setter methods to manage the sessions values being passed to this class
 * and in return makes the current sessions and stores them in a text file on the local desktop.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk> - Modified by Users: P14184295 and P14166609
 * @copyright De Montfort University
 */

class SessionModel
{
	private $c_username;
	private $c_server_type;
	private $c_password;
	private $c_arr_storage_result;
	private $c_obj_wrapper_session;
	private $c_obj_wrapper_db;

	/**
   * Default constructor initialises the values to null
   */

	public function __construct()
	{
		$this->c_username = null;
		$this->c_server_type = null;
		$this->c_password = null;
		$this->c_arr_storage_result = null;
		$this->c_obj_wrapper_session = null;
		$this->c_obj_wrapper_db = null;
	}

	public function __destruct() { }

	/**
   * set_session_values($p_sanitisied_username, $p_sanitised_password) sets the username and password
	 * values which is used within this class for configuration.
   *
   * @param - $p_sanitised_username - sets the username
	 * @param -  $p_sanitised_password - sets the password
   * @return - None
   */

	public function set_session_values($p_sanitised_username, $p_sanitised_password)
	{
		$this->c_username = $p_sanitised_username;
		$this->c_password = $p_sanitised_password;
	}

	/**
   * set_wrapper_session($p_obj_wrapper_session) sets the session wrapper which is used
	 * within this class for managing the session storage as well as storing information in a file
   *
   * @param - $p_obj_wrapper_session - sets the session wrapper
   * @return - None
   */

	public function set_wrapper_session($p_obj_wrapper_session)
	{
		$this->c_obj_wrapper_session = $p_obj_wrapper_session;
	}

	/**
   * do_storage() does the storing of the session values and creates a text file
   *
   * @param - None
   * @return - None
   */

	public function do_storage()
	{
		$this->c_arr_storage_result['file'] = $this->do_store_data_in_session_file(); //uses the private function within this class to retrieve values
	}

	/**
   * get_storage_result() returns the result of the session storage which is a boolean value indicating the success of the storage
   *
   * @param - None
   * @return - returns a boolean indicating the succes of the storage
   */

	public function get_storage_result()
	{
		return $this->c_arr_storage_result['file'];
	}

	/*
   * do_store_data_in_session_file() is a private function which sets the session values provided within this class and creates a
	 * text file which includes the session values in a file.
   */

	private function do_store_data_in_session_file()
	{
		$m_store_result = false;																																																//current state representing the session values have not been set
		$m_store_result_username = $this->c_obj_wrapper_session->set_session('username', strtolower($this->c_username));				//sets the session values for username and password
		$m_store_result_password = $this->c_obj_wrapper_session->set_session('password', $this->c_password);

		if ($m_store_result_username !== false && $m_store_result_password !== false)	{																					//if the values are set sucessfully then the state is represented as true
			$m_store_result = true;																																																//and a text file is created
			$m_session_file = fopen("sessionfile.txt", "w");
			$m_session_details =  "Session Details - " . $this->c_obj_wrapper_session->get_session('username') . "  " . $this->c_obj_wrapper_session->get_session('password');
			fputs($m_session_file, $m_session_details);
			fclose($m_session_file);
		}
		return $m_store_result;
	}

}
