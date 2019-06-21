<?php

/**
* Created by PhpStorm and Atom Editors.
* Users: P14184295 and (add your pnumber here RAJ)
* Date: 20/11/2016
*
* register.php
*
* One of the files the routes load is this register.php file.
*
* This file initialises the settings used by the register page by
* setting up the appropriate sanitisation and validation checks which are used to
* check the values are not malicious and uses this information to register the user and
* store their information into the database.
*/

$f_class_path = $app->config('classes.path') . DIRSEP;                    //requies path information and stores it in variable
$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_class_path . 'ValidateModel.php';                         //variable information is then used for concatenating with the required
require_once $f_class_path . 'RegisterModel.php';                         //php files which are required_once and loaded
require_once $f_wrapper_path . 'MySQL_Wrapper.php';
require_once $f_wrapper_path . 'Session_Wrapper.php';

$app->post('/register', function() use ($app)
{
  if($app->request->post('submit')) {                                       //if form is submitted, then store the form values into variables
    $f_obj_db = new MySQL_Wrapper();
    $f_obj_db->connect_to_database();

    $f_obj_logger= new AppLoggerModel();
    $f_obj_logger->set_database_handle($f_obj_db);
    $f_obj_logger->do_get_database_connection_result();
    $f_obj_logger->do_logging(null,'register');


    $f_arr_credintials['Reg_username'] = $app->request->post('reg_username');
    $f_arr_credintials['Reg_password'] = $app->request->post('reg_password');
    $f_arr_credintials['Reg_email'] = $app->request->post('reg_email');

    //if the values are empty then return a error message

    if(empty($f_arr_credintials['Reg_username']) || empty($f_arr_credintials['Reg_password']) || empty($f_arr_credintials['Reg_email'])) {
        $f_obj_logger->do_logging(null,'user trying to register with empty fields');
        return $app->redirect('reg_missing_value_error');
    }else {

      /*
       * if values are not empty then the ValidateModel() is instantiated and the values are
       * sanitised and validated. They are then checked if the validation/sanitisation has passed then
       * the values can be stored by called the registered($credintials), if it passes then the
       * user is redirected to the authentication page where they can login otherwise errors are thrown.
       */

      $f_obj_validate = new ValidateModel();
      $f_sanitised_username = $f_obj_validate->sanitise_string($f_arr_credintials['Reg_username']);
      $f_sanitised_password = $f_obj_validate->sanitise_string($f_arr_credintials['Reg_password']);
      $f_sanitised_email = $f_obj_validate->sanitise_string($f_arr_credintials['Reg_email']);

      if($f_sanitised_username && $f_sanitised_password && $f_sanitised_email) {

        $f_validated_username = $f_obj_validate->validate_string($f_arr_credintials['Reg_username']);
        $f_validated_password = $f_obj_validate->validate_string($f_arr_credintials['Reg_password']);
        $f_validated_email = $f_obj_validate->validate_email($f_arr_credintials['Reg_email']);

        if($f_validated_username === true && $f_validated_password === true && $f_validated_email === true) {
          $f_result=registered($f_arr_credintials,$f_obj_db);

          if($f_result===-1)
          {
              $f_obj_logger->do_logging(null,'error while registering new user');
              return $app->redirect('error');
          }
          if($f_result) {
              $f_obj_logger->do_logging($f_arr_credintials['Reg_username'],'new user registered successfully');
              $app->response->redirect($app->urlFor('authentication'));

          }else {
              $f_obj_logger->do_logging(null,'new user trying to register, user already present');
              return $app->redirect('reg_wrong_input_error');

          }

        }else {
          $f_obj_logger->do_logging(null,'user trying to register with empty/invalid data');
          return $app->redirect('reg_missing_value_error');
        }
      }
    }
  }
});

/*
 * registered($p_credintials) is a function used to initialise the MySQL_Wrapper and RegisterModel
 * for setting up the necessary connections and handles and used for registering the user.
 */

function registered($p_credintials,$p_db_handle) {

  $f_obj_register_handle = new RegisterModel();
  $f_obj_register_handle->set_database_handle($p_db_handle);
  $f_obj_register_handle->do_get_database_connection_result();
  $f_obj_register_handle->set_user_credintials($p_credintials['Reg_username'], $p_credintials['Reg_password'], $p_credintials['Reg_email']);
  $f_admin_registered = $f_obj_register_handle->get_user_credintials();
  if($f_obj_register_handle->do_error_exist())
  {
      $f_admin_registered=-1;
  }

  return $f_admin_registered;
}
