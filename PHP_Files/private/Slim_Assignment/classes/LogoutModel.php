<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 26/11/2016
 *
 * LogoutModel.php
 *
 * One of the class files used by the system is the LogoutModel.php file.
 *
 * Here the Logout Model can be reused for handling any user information.
 * It hides any important details from being handled else where and provides
 * functions to handle any incoming user information, returning reliable results.
 *
 * It uses the do_logout() method to logout current user that is logged in.
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;             //requies path information and stores it in variable

require_once $f_wrapper_path . 'Session_Wrapper.php';                 //variable information is then used for concatenating with the required
                                                                      //php files which are required_once and loaded
//include(__DIR__ . '/../wrappers/Session_Wrapper.php');                 //these include is needed for testing purposes, comment above requires for testing


class LogoutModel
{

  public function __construct(){}

  public function __destruct(){}

  /**
   * do_logouts() this method disables all current Sessions that are available and doing so
   * will cause the user information to be unsafed. A value is returned indicating the
   * state of the users logged in status, true indicates they have successfully logged out.
   *
   * @param - None
   * @return - returns boolean value indicating the state of whether user has logged out or not
   */

  public function do_logout()
  {
    $m_result = false;                                                    //value used to keep track of user state, current is false meaning user has not logged out

    $m_username_not_set = Session_Wrapper::unset_session('username');     //session values are unset
    $m_password_not_set = Session_Wrapper::unset_session('password');

    if($m_username_not_set !==false && $m_password_not_set !==false) {    //if values are not set then the state is changed to true indicating the user has logged out and
      $m_result = true;                                                   //information stored in sessionfile.txt is cleared
      $m_session_file = fopen("sessionfile.txt", "w");
			$m_session_details =  "";
			fputs($m_session_file, $m_session_details);
			fclose($m_session_file);
    }

    return $m_result;
  }

}
