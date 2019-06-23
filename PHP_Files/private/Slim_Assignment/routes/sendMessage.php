<?php

$f_class_path = $app->config('classes.path') . DIRSEP;                      //requies path information and stores it in variable
$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_class_path . 'ValidateModel.php';                           //variable information is then used for concatenating with the required
require_once $f_class_path . 'SendMessageModel.php';                       //php files which are required_once and loaded
require_once $f_wrapper_path . 'MySQL_Wrapper.php';
require_once $f_wrapper_path . 'Soap_Wrapper.php';

require_once $f_wrapper_path . 'Session_Wrapper.php';
require_once $f_wrapper_path . 'OpenSSL_Wrapper.php';
require_once $f_class_path . 'AppLoggerModel.php';

$app->get('/sendMessage', function() use ($app)
{
    if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
      return  $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
    }

    $f_obj_validate = new ValidateModel();                                 //instantiates the required classes
    $f_obj_send_model = new SendMessageModel();
    $f_obj_MySQL = new MySQL_Wrapper();
    $f_obj_MySQL->connect_to_database();
    $f_obj_soap = new Soap_Wrapper();

    //------------------Logger
    $f_obj_openssl_wrapper = new OpenSSLEncr();
    $f_userID = $f_obj_openssl_wrapper->decrypt(Session_Wrapper::get_session('username'));
    $f_userID = Session_Wrapper::get_session('username');

    $f_obj_logger= new AppLoggerModel();
    $f_obj_logger->set_database_handle($f_obj_MySQL);
    $f_obj_logger->do_get_database_connection_result();
    $f_obj_logger->do_logging($f_userID,'Sending message!');
    //----------------------------------------------


    //*********************************************DOWNLOAD*******************************

    $f_message = $app->request->get('message-id');                        //gets the message id
    if(!empty($f_message))                                                 //if message id is empty than it downloads all messages
    {
        $f_validated_message =$f_obj_validate->validate_phone($f_message);  //if value is provided than it is validated
    }

    //If validation fails than the number is not valid
    if($f_validated_message===false)
    {
        $f_obj_logger->do_logging($f_userID,': Error in the MSISDN!');
        return $app->redirect('error');
    }

    /*
     * sets the message id and the WSDL file along with initialising the SOAP client handle,
     * once the setup is complete, the messages can be downloaded
     */

    $f_obj_send_model->set_message_id($f_validated_message);
    $f_obj_soap->set_wsdl('https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl');
    $f_obj_soap->make_soap_client();

    $f_obj_soap_handle = $f_obj_soap->get_soap_client_handle();

    if($f_obj_soap_handle===null)
    {
        $f_obj_logger->do_logging($f_userID,': Invalid SOAP client handle. ');
        return $app->redirect('error');
    }

    $f_obj_send_model->set_soap_client_handle($f_obj_soap_handle);


// WORK FROM HEREEEEEEE!

    $f_obj_send_model->do_send_message();
    if(!$f_obj_send_model->verifyMessageSent())
    {
        $f_obj_logger->do_logging($f_userID,' Error sending messages. Retry!');
        return $app->redirect('error');
    }
    else
    {
        $f_obj_logger->do_logging($f_userID,'Message sent successfully!');
    }

    return $app->redirect('homepage');

});
