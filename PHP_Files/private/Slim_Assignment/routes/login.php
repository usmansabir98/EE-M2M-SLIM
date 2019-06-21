<?php

/**
* Created by PhpStorm and Atom Editors.
* Users: P14184295 and P14166609
* Date: 20/11/2016
*
* login.php
*
* One of the files the routes load is this login.php.
*
* This file initialises the settings used by the login page by
* setting up the appropriate sanitisation and validation checks which are used to
* check the values are not malicious and uses this information to log the user into
* the homepage successfully.
*/

$f_class_path = $app->config('classes.path') . DIRSEP;                    //requies path information and stores it in variable
$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_class_path . 'ValidateModel.php';                         //variable information is then used for concatenating with the required
require_once $f_class_path . 'LoginModel.php';                            //php files which are required_once and loaded
require_once $f_class_path . 'SessionModel.php';
require_once $f_class_path . 'AppLoggerModel.php';

require_once $f_wrapper_path . 'Session_Wrapper.php';
require_once $f_wrapper_path . 'MySQL_Wrapper.php';

$app->post('/login', function() use ($app)
{
  $f_obj_wrapper_db = new MySQL_Wrapper();
  $f_obj_wrapper_db->connect_to_database();

  //------------Logger
  $f_obj_logger= new AppLoggerModel();
  $f_obj_logger->set_database_handle($f_obj_wrapper_db);
  $f_obj_logger->do_get_database_connection_result();
  $f_obj_logger->do_logging(null,'login');
  //----------------------------------------------------------
  if($app->request->post('submit')) {                                               //checks for the POST submission
    $f_arr_credintials['Username'] = $app->request->post('username');               //if something is submitted than the values passed are stored in variables
    $f_arr_credintials['Password'] = $app->request->post('password');

    if(empty($f_arr_credintials['Username']) || empty($f_arr_credintials['Password'])) {  //if the stored values are empty than the error message is outputted
      return $app->redirect('login_missing_value_error');
    }else {

      /*
       * if the values are not empty than the ValidateModel() is instantiated
       * the values passed are sanitised and validated. If the values have been successfully
       * validated than they are passed on to the functions login and session to initalise
       * certain configurations. If that passes than the user is directed to the homepage
       * else an error is displayed.
       */

      $f_obj_validate = new ValidateModel();

      $f_sanitised_username = $f_obj_validate->sanitise_string($f_arr_credintials['Username']);
      $f_sanitised_password = $f_obj_validate->sanitise_string($f_arr_credintials['Password']);

      if($f_sanitised_username && $f_sanitised_password) {
        $f_validated_username = $f_obj_validate->validate_string($f_arr_credintials['Username']);
        $f_validated_password = $f_obj_validate->validate_string($f_arr_credintials['Password']);

        if($f_validated_username === true && $f_validated_password === true) {
            $f_result=login($f_arr_credintials,$f_obj_wrapper_db);
            if($f_result===-1)
            {
                $f_obj_logger->do_logging(null,'error while logging in user');
                return $app->redirect('error');
            }
            if($f_result && session($f_arr_credintials)) {
                $f_obj_logger->do_logging($f_arr_credintials['Username'],'user login success');
                session_regenerate_id(true);	//regenerates session id's, keeps current information with new id
                return $app->redirect('homepage');

            }else {

                $f_obj_logger->do_logging(null,'user not registered');
                return $app->redirect('login_wrong_input_error');

            }
        }else {
          $f_obj_logger->do_logging(null,'user logging with wrong/incorrect info');
          return $app->redirect('login_wrong_input_error');
        }
      }
    }
  }
})->name('login');

/*
 * session($p_credintials) is a function used to initialise the Session_Wrapper and SessionModel
 * for setting up the necessary sessions and used for logging in the user.
 */

function session($p_credintials) {
  $f_obj_wrapper_session = new Session_Wrapper();
  $f_obj_data_store = new SessionModel();
  $f_obj_data_store->set_wrapper_session($f_obj_wrapper_session);
  $f_obj_data_store->set_session_values($p_credintials['Username'], $p_credintials['Password']);
  $f_obj_data_store->do_storage();
  $f_obj_get_storage_result = $f_obj_data_store->get_storage_result();

  return $f_obj_get_storage_result;
}

/*
 * login($p_credintials) is a function used to initialise the MySQL_Wrapper and LoginModel
 * for setting up the necessary connections and handles and used for logging in the user.
 */

function login($p_credintials,$p_db_handle) {

  $f_obj_login_handle = new LoginModel();
  $f_obj_login_handle->set_database_handle($p_db_handle);
  $f_obj_login_handle->do_get_database_connection_result();
  $f_obj_login_handle->set_admin_credintials($p_credintials['Username'], $p_credintials['Password']);
  $f_admin_login = $f_obj_login_handle->do_admin_credintials();

  if($f_obj_login_handle->do_error_exist())
  {
      $f_admin_login=-1;
  }

  return $f_admin_login;

}
