<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * downloaddata.php
 *
 * One of the files the route loads is this downloaddata.php file
 *
 * This file initialises the downloading, validation and storing
 * configurations of the downloaded messages from the EE M2M server
 * provided by the message id
 */

$f_class_path = $app->config('classes.path') . DIRSEP;                      //requies path information and stores it in variable
$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_class_path . 'ValidateModel.php';                           //variable information is then used for concatenating with the required
require_once $f_class_path . 'DataDownloadModel.php';                       //php files which are required_once and loaded
require_once $f_class_path . 'DataStoreModel.php';
require_once $f_wrapper_path . 'MySQL_Wrapper.php';
require_once $f_wrapper_path . 'Soap_Wrapper.php';

require_once $f_wrapper_path . 'Session_Wrapper.php';
require_once $f_wrapper_path . 'MCrypt_Wrapper.php';
require_once $f_class_path . 'AppLoggerModel.php';

$app->get('/downloaddata', function() use ($app)
{
    if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
      return  $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
    }

    $f_obj_validate = new ValidateModel();                                 //instantiates the required classes
    $f_obj_model = new DataDownloadModel();
    $f_obj_store_model = new DataStoreModel();
    $f_obj_MySQL = new MySQL_Wrapper();
    $f_obj_MySQL->connect_to_database();
    $f_obj_soap = new Soap_Wrapper();

    //------------------Logger
    // $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();
    // $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();
    // $f_userID = $f_obj_mcrypt_wrapper->decrypt(Session_Wrapper::get_session('username'));
    $f_userID = Session_Wrapper::get_session('username');


    $f_obj_logger= new AppLoggerModel();
    $f_obj_logger->set_database_handle($f_obj_MySQL);
    $f_obj_logger->do_get_database_connection_result();
    $f_obj_logger->do_logging($f_userID,'downloading');
    //----------------------------------------------


    //*********************************************DOWNLOAD*******************************

    $f_message = $app->request->get('message-id');                        //gets the message id
    if(empty($f_message))                                                 //if message id is empty than it downloads all messages
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
        $f_obj_logger->do_logging($f_userID,'error message validation download');
        return $app->redirect('download_error');
    }

    /*
     * sets the message id and the WSDL file along with initialising the SOAP client handle,
     * once the setup is complete, the messages can be downloaded
     */

    $f_obj_model->set_message_id($f_validated_message);
    $f_obj_soap->set_wsdl('https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl');
    $f_obj_soap->make_soap_client();

    $f_obj_soap_handle = $f_obj_soap->get_soap_client_handle();

    if($f_obj_soap_handle===null)
    {
        $f_obj_logger->do_logging($f_userID,'error soap client handle is null');
        // echo "ERRORRRRRR";
        return $app->redirect('error');
    }

    $f_obj_model->set_soap_client_handle($f_obj_soap_handle);
    $f_obj_model->do_download_message();
    if($f_obj_model->do_error_exist())
    {
        $f_obj_logger->do_logging($f_userID,'error downloading message!!!');
        return $app->redirect('error');
    }
    else
    {
        $f_obj_logger->do_logging($f_userID,'message downloaded success');
    }


    //if the messages are empty redirect to homepage

    if(!empty($f_obj_model->get_downloaded_message_data())) {



        //*******************************************DOWNLOAD END

        //********************************************VALIDATE**********************************


        //here the downloaded messages are validated and set

        // $f_validate_message_data = $f_obj_validate->validate_size($f_obj_model->get_downloaded_message_data());
        // $f_obj_model->set_downloaded_message_data($f_validate_message_data);

        // print_r($f_obj_model->get_downloaded_message_data());

        $f_validate_message_data = $f_obj_validate->validate_array_message($f_obj_model->get_downloaded_message_data());
        $f_obj_model->set_downloaded_message_data($f_validate_message_data);

        // print_r($f_obj_model->get_downloaded_message_data());


        //********************************************VALIDATE END

        //********************************************STORE*************************************

        //here the connection to database is made and the downloaded messages are stored


        $f_obj_store_model->set_database_handle($f_obj_MySQL);
        $f_obj_store_model->do_get_database_connection_result();
        $f_obj_store_model->set_downloaded_message_data($f_obj_model->get_downloaded_message_data());
        $f_obj_store_model->do_store_downloaded_message_data();
        if($f_obj_store_model->do_error_exist())
        {
            $f_obj_logger->do_logging($f_userID,'error storing downloaded messages');
            return $app->redirect('error');
        }
        else
        {
            $f_obj_logger->do_logging($f_userID,'message downloaded stored');
        }

        //********************************************STORE END
    }
    else
    {
        $f_obj_logger->do_logging($f_userID,'message downloaded: 0');
    }
    return $app->redirect('homepage');

});
