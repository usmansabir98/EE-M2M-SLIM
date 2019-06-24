<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * RegisterModel.php
 *
 * One of the class files used by the system is the RegisterModel.php file.
 *
 * Here the Register Model can be reused for handling any user information.
 * It hides any important details from being handled else where and provides
 * functions to handle any incoming user information, returning reliable results.
 *
 * It uses the handles and do'er methods to handle user credinitials and register user
 * into the system. A single get method is provided to return the sucess of the user registration.
 */

 $f_wrapper_path = $app->config('wrappers.path') . DIRSEP;                //requies path information and stores it in variable

 require_once $f_wrapper_path . 'OpenSSL_Wrapper.php';                     //variable information is then used for concatenating with the required
 require_once $f_wrapper_path . 'SQL_Wrapper.php';                        //php files which are required_once and loaded

include_once(__DIR__ . '/../wrappers/OpenSSL_Wrapper.php');     //Switched to include_once()!           
include_once(__DIR__ . '/../wrappers/SQL_Wrapper.php');

class RegisterModel
{
  private $c_obj_database_handle;
  private $c_arr_user_data;
  private $c_arr_store_boolean;
  private $c_arr_database_connection_messages;
  private $c_error;

  /**
   * Default constructor initialises the values to null
   */

  public function __construct()
  {
    $this->c_obj_database_handle = null;
    $this->c_arr_user_data = array();
    $this->c_arr_store_boolean = false;
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
   * set_user_credintials(($p_sanitised_obj_username, $p_sanitised_obj_password, $p_sanitised_obj_email) sets the
   * the user credintials for this class to use in other methods to process the configuration for registration of the user.
   *
   * @param - $p_sanitised_obj_username - sets the username
   * @param - $p_sanitised_obj_password - sets the password
   * @param - $p_sanitised_obj_email - sets the email
   * @return - None
   */
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

  public function set_user_credintials($p_sanitised_obj_username, $p_sanitised_obj_password, $p_sanitised_obj_email) {
    $this->c_arr_user_data['Username'] = $p_sanitised_obj_username;
    $this->c_arr_user_data['Password'] = $p_sanitised_obj_password;
    $this->c_arr_user_data['E-mail'] = $p_sanitised_obj_email;
  }

  /**
   * get_user_credintials(() gets the user state indicating the success/failure of the registration
   *
   * @param - None
   * @return - returns the success/failure state of the user registration
   */

  public function get_user_credintials() {
    $this->do_user_credintials();
    return $this->c_arr_store_boolean;
  }

  /*
   * do_user_credintials() gets the information provided to this class and queries the database
   * to ensure the values are not stored previously, this method registers the user.
   */

  private function do_user_credintials()
  {
    $m_arr_store_boolean = false;                       //these values are used for storing the state of the registered user, false defines the user has not registered.
    $m_boolean_check_stored_value = false;
    $m_error=$this->c_error;

    $m_id = $this->do_id();                             //everytime the user is registering, the user_id is incremented for defining a unique user
    $m_id++;

    $m_username = $this->c_arr_user_data['Username'];   //credinitials that were passed are now being stored in variables to be used within queries
    $m_password = $this->c_arr_user_data['Password'];
    $m_email = $this->c_arr_user_data['E-mail'];

    $m_sql_wrapper = new SQL_Wrapper;                      //instantiates SQL_Wrapper()

    $f_obj_openssl_wrapper = new OpenSSLEncr();

    $m_encrypted_password = $f_obj_openssl_wrapper->encrypt($m_password);      //encrypts the password before storing

    $m_sql_query_string=   $m_sql_wrapper->set_user_credintials();
    $m_arr_sql_query_parameters = array(':ID' => $m_id, ':Username' => $m_username, ':Password' => $m_password, ':Email' => $m_email);

    if($this->do_id() === 0) {                                                //checks to see if there are any registered users, if none then register new user

        if(!$this->c_arr_database_connection_messages['database-connection-error'])
        {
            if($this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters)) {
                $m_arr_store_boolean = true;
                $this->c_arr_store_boolean = $m_arr_store_boolean;
            }
        }
        else
        {
            $m_error++;
        }


    }else {                                                                   //else if there are users, then checks to see if there are any conflicts between registering and stored users

      $m_boolean_check_stored_value = $this->do_check_username_and_email();

      if($m_boolean_check_stored_value === true) {                            //if not then store them to database else displays error

          if(!$this->c_arr_database_connection_messages['database-connection-error'])
          {
              if($this->c_obj_database_handle->safe_query($m_sql_query_string, $m_arr_sql_query_parameters)) {
                  $m_arr_store_boolean = true;
                  $this->c_arr_store_boolean = $m_arr_store_boolean;
              }
          }
          else
          {
              $m_error++;
          }

      }

    }
    $this->c_error=$m_error;

  }

  /*
   * do_check_username and_email() queries the database for the username and email to ensure
   * any new user registering is not entering in similar information as previously stored.
   */

  private function do_check_username_and_email() {

    $m_username = $this->c_arr_user_data['Username'];           //credinitials that were passed are now being stored in variables to be used within queries
    $m_email = $this->c_arr_user_data['E-mail'];
    $m_error=$this->c_error;

    $m_sql_wrapper = new SQL_Wrapper;                      //instantiates SQL_Wrapper()
    $m_sql_query_string = $m_sql_wrapper->get_stored_username_and_email();
    $m_store = true;
    if(!$this->c_arr_database_connection_messages['database-connection-error'])
    {
        $this->c_obj_database_handle->safe_query($m_sql_query_string, null);       //queries the stored values
        $m_number_of_rows = $this->c_obj_database_handle->fetch_All();                                              //returns all rows



        foreach($m_number_of_rows as $key) {                                                                        //if there are values then the user trying to register is compared against stored values

            if(strtolower($key[0]) == strtolower($m_username) || strtolower($key[1]) == strtolower($m_email)) {
                $m_store = false;
                break;
            }

        }
    }
    else
    {
      $m_error++;
    }

    $this->c_error=$m_error;
    return $m_store;                                                                               //returns the state for the registering user

  }

  /*
   * do_id() increments the number for the User_ID stored within the database. This is the primary key
   * used to keep unique information on a particular user.
   */

  private function do_id() {
                                                            //instantiates SQL_Wrapper()
    $m_sql_wrapper = new SQL_Wrapper;                      //instantiates SQL_Wrapper()
    $m_sql_query_string = $m_sql_wrapper->get_admin_id();
    $m_error=$this->c_error;

    $m_current_id = -1;
    if(!$this->c_arr_database_connection_messages['database-connection-error'])
    {
        $this->c_obj_database_handle->safe_query($m_sql_query_string, null);          //safely queries the User_ID
        $m_number_of_rows = $this->c_obj_database_handle->fetch_All();                                //fetches all rows

        //arr used for storing the current id

        if(!isset($m_number_of_rows[0])) {
            $m_current_id = 0;
        }else {
            foreach($m_number_of_rows as $key) {
                $m_current_id = $key[0];
            }
        }
    }
    else
    {
        $m_error++;
    }

    $this->c_error=$m_error;
    return $m_current_id;                                                                  //returns the previous id which is updated to the new id when storing user information
  }

}
