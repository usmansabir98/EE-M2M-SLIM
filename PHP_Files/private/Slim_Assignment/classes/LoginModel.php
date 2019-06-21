<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * LoginModel.php
 *
 * One of the class files used by the system is the LoginModel.php file.
 *
 * Here the Login Model can be reused for handling any user information.
 * It hides any important details from being handled else where and provides
 * functions to handle any incoming user information, returning reliable results.
 *
 * It uses setter methods to set any username and password information which is used
 * against the passed database handle and uses the do'er methods to check if that user
 * exists
 */

 $f_wrapper_path = $app->config('wrappers.path') . DIRSEP;           //requies path information and stores it in variable

 require_once $f_wrapper_path . 'MCrypt_Wrapper.php';                //variable information is then used for concatenating with the required
 require_once $f_wrapper_path . 'SQL_Wrapper.php';                   //php files which are required_once and loaded

 //include(__DIR__ . '/../wrappers/MCrypt_Wrapper.php');                 //these include is needed for testing purposes, comment above requires for testing
 //include(__DIR__ . '/../wrappers/SQL_Wrapper.php');

class LoginModel
{
  private $c_obj_database_handle;
  private $c_arr_admin_data;
  private $c_arr_database_connection_messages;
  private $c_error;

  /**
   * Default constructor initialises the values to null
   */

  public function __construct()
  {
    $this->c_obj_database_handle = null;
    $this->c_arr_admin_data = array();
    $this->c_arr_database_connection_messages = array();
    $this->c_error=0;
  }

  public function __destruct(){}

  /**
   * set_database_handle($p_obj_database_handle) sets the database handle provided by the user
   * and uses the database handle to connect to the database
   *
   * @param - $p_obj_database_handle - sets the database handle
   * @return - None
   */

  public function set_database_handle($p_obj_database_handle)
  {
    $this->c_obj_database_handle = $p_obj_database_handle;
  }

  /**
   * set_admin_credintials($p_sanitised_obj_username, $p_sanitised_obj_password) this method sets the username and
   * password details which are first sanitised and validated before storing.
   *
   * @param - $p_sanitised_obj_username - sets the username
   * @param - $p_sanitised_obj_password - sets the password
   * @return - None
   */


  public function set_admin_credintials($p_sanitised_obj_username, $p_sanitised_obj_password) {
    $this->c_arr_admin_data['Username'] = $p_sanitised_obj_username;
    $this->c_arr_admin_data['Password'] = $p_sanitised_obj_password;
  }

  /**
  * do_get_database_connection_result gets the error message from mysql
  * and sets to local array
  *
  * @param - $p_obj_database_handle - sets the message data
  * @return - None
  */
  public function do_get_database_connection_result()
  {
    $this->c_arr_database_connection_messages = $this->c_obj_database_handle->get_connection_messages();
  }

  /**
   * do_error_exist() function check if there are errors
   *
   * @param - None
   * @return - true or false depending on the presence of errors;
   */
  public function do_error_exist()
  {
    if($this->c_error>0)
    {
       return true;
    }

    else
    {
      return false;
    }
  }
  /**
   * do_admin_credintials() this method uses the values that were set to connect to the database handle
   * and query against the database to check if the values passed were stored in the database, if so
   * then the user is logged in.
   *
   * @param - None
   * @return - returns boolean value indicating the state of whether user has logged in or not
   */

  public function do_admin_credintials()
  {
    $m_username = $this->c_arr_admin_data['Username'];          //gets the username and password from the previously set fields
    $m_password = $this->c_arr_admin_data['Password'];
    $m_sql_wrapper=new SQL_Wrapper;
    $m_sql_query_string = $m_sql_wrapper->get_admin_credintials();                  //instantiates SQL_Wrapper() and MCrypt_Wrapper()
    // $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();
    // $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();
    $m_arr_store_boolean = false;           //state represents if user is within the database or not
    $m_error=$this->c_error;

    if(!$this->c_arr_database_connection_messages['database-connection-error'])
    {
        $this->c_obj_database_handle->safe_query($m_sql_query_string, null);   //a query is made and the number of rows are returned
        $m_number_of_rows = $this->c_obj_database_handle->fetch_All();



        foreach($m_number_of_rows as $key) {    //goes through the number of rows that were returned, if the value exists than the state is true else false to indicate there are no such users

            if(strtolower($key[0]) == strtolower($m_username) &&  strtolower($key[1]) == $m_password) {    //decrypt is needed for decrypting the encrypted session value
                $m_arr_store_boolean = true;                                                                                     //to check against the database
                break;
            }

        }
    }
    else
    {
        $m_error++;
    }

    $this->c_error=$m_error;
    return $m_arr_store_boolean;
  }

}
