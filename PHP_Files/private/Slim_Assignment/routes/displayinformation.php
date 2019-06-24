<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * displayinformation.php
 *
 * One of the files the route loads is this displayinformation.php file
 *
 * This route is responsible for displaying stored messages.
 * It also renders the default display page to show the downloaded messages.
 */

$f_class_path = $app->config('classes.path') . DIRSEP;                    //requies path information and stores it in variable
$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_wrapper_path . 'HTML_Wrapper.php';
require_once $f_wrapper_path . 'MySQL_Wrapper.php';                       //variable information is then used for concatenating with the required
require_once $f_class_path . 'DataDisplayModel.php';                      //php files which are required_once and loaded
require_once $f_class_path . 'ValidateModel.php';

require_once $f_wrapper_path . 'Session_Wrapper.php';
require_once $f_wrapper_path . 'OpenSSL_Wrapper.php';
require_once $f_class_path . 'AppLoggerModel.php';

$app->get('/displayinformation', function() use ($app)
{
    if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
       return $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
    }

    $f_obj_openssl_wrapper = new OpenSSLEncr();
    $f_userID = $f_obj_openssl_wrapper->decrypt(Session_Wrapper::get_session('username'));
    $f_userID = Session_Wrapper::get_session('username');

    $f_obj_MySQL = new MySQL_Wrapper();
    $f_obj_MySQL->connect_to_database();
    //-----------------Logger initialisation
    $f_obj_logger= new AppLoggerModel();
    $f_obj_logger->set_database_handle($f_obj_MySQL);
    $f_obj_logger->do_get_database_connection_result();
    $f_obj_logger->do_logging($f_userID,'displaying');
    //---------------------------------------------------------


    $f_obj_validate = new ValidateModel();                                //instantiates new ValidateModel()
    $f_message = $app->request->get('message-id');                        //returns the message id




    if(empty($f_message))                                                 //if message id is empty than it displays all messages
    {
        $f_validated_message = '-1';
    }
    else
    {
        $f_validated_message =$f_obj_validate->validate_phone($f_message);  //if value is provided than it is validated
    }

    //if validation fails than the number is not valid



    if($f_validated_message===false)
    {
        $f_obj_logger->do_logging($f_userID,'error message validation display');
        return $app->redirect('display_error');
    }
    else
    {

        /*
         * else instantiate MySQL_Wrapper() and DataDisplayModel()
         * and set the validated value as the message id.
         * Connect to the database and required handles.
         * Once all is set, retrieve the stored messages as well as the meta data
         * and pass it to the $app array for rendering the required information
         */

        //$f_obj_MySQL = new MySQL_Wrapper();
        $f_obj_display_model = new DataDisplayModel();
        $f_obj_display_model->set_message_id($f_validated_message);
        //$f_obj_MySQL->connect_to_database();

        $f_obj_display_model->set_database_handle($f_obj_MySQL);
        $f_obj_display_model->do_get_database_connection_result();

        $f_obj_display_model->do_retrieve_stored_message_data();
        $f_stored_messages = $f_obj_display_model->get_stored_message_data();
        $f_obj_display_model->do_retrieve_metadata();
        $f_metadata = $f_obj_display_model->get_metadata();

        if($f_obj_display_model->do_error_exist())
        {
            $f_obj_logger->do_logging($f_userID,'error with displaying ');
            return $app->redirect('error');
        }

        $f_html_wrapper = new HTML_Wrapper();

        $f_script_name = $_SERVER["SCRIPT_NAME"];                             //current scripts path

        $f_app_name = 'EE Client - Review Stored Data';

        $f_header = $f_html_wrapper->get_header();
        $f_html_wrapper->do_display_page_processing($f_metadata, $f_stored_messages);
        $f_html_output = $f_html_wrapper->get_display_page_processed();

        $arr = [                                                              //all values initialised are stored in this array and passed into
            //the render function along with the php file needed for render
            'landing_page' => $f_script_name,
            'header' => $f_header,
            'page_title' => $f_app_name,                                      //title name of the current page
            'html_output' => $f_html_output

        ];
        
        $f_obj_logger->do_logging($f_userID,'message displayed');
        $app->render('display_storedmessages.php', $arr);
    }






});
