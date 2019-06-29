<?php

/**
 * 
 * homepage.php
 *
 * One of the files the routes load is this homepage.php file.
 *
 * This file initialises the settings used by the Slim array
 * and used for storing information on reoccuring information.
 * The reoccuring information is the information stored in the array which is used
 * for loading the appropriate contents within the HTML markup.
 *
 * It also renders the home page after the user has logged in successfully.
 */

 $f_wrapper_path = $app->config('wrappers.path') . DIRSEP;              //requies path information and stores it in variable

 require_once $f_wrapper_path . 'Session_Wrapper.php';                  //variable information is then used for concatenating with the required
 require_once $f_wrapper_path . 'OpenSSL_Wrapper.php';                   //php files which are required_once and loaded
 require_once $f_wrapper_path . 'HTML_Wrapper.php';

 $app->get('/homepage', function() use ($app)
 {
   if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
       $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
   }else {

     /*
      * if the SESSION is available then the OpenSSL_Wrapper() is inistantiated
      * with this, the logged in username is usually encrypted so to display it on the homepage
      * it is first decrypted then passed into the $app array to configure the settings
      */

     $f_obj_openssl_wrapper = new OpenSSLEncr();

     $f_admin = ucfirst($f_obj_openssl_wrapper->decrypt(Session_Wrapper::get_session('username')));

     $f_app_name = 'EE Client - Home';                                    //title name of the current page

     $f_script_name = $_SERVER["SCRIPT_NAME"];                            //current scripts path

     $f_html_wrapper = new HTML_Wrapper();

     $f_header = $f_html_wrapper->get_header();
     $f_html_output = $f_html_wrapper->get_homepage_page_form()['html_output'];
     $f_html_output2 = $f_html_wrapper->get_homepage_page_form()['html_output2'];

     $arr = [
       'landing_page' => $f_script_name,                                 //all values initialised are stored in this array and passed into
       'admin' => 'Hi there, ' . $f_admin,                                  //the render function along with the php file needed for render
       'header' => $f_header,
       'page_title' => $f_app_name,
       'html_output' => $f_html_output,
       'html_output2' => $f_html_output2,
     ];

     $app->render('display_homepage.php', $arr);
   }
 })->name('homepage');

 $app->get('/homepage_error', function() use ($app)
 {
   if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
       $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
   }else {

     /*
      * if the SESSION is available then the OpenSSL_Wrapper() is inistantiated
      * with this, the logged in username is usually encrypted so to display it on the homepage
      * it is first decrypted then passed into the $app array to configure the settings
      */

     $f_obj_openssl_wrapper = new OpenSSLEncr();

     $f_admin = $f_obj_openssl_wrapper->decrypt(Session_Wrapper::get_session('username'));
     $f_admin = Session_Wrapper::get_session('username');

     $f_app_name = 'EE-M2M Client';                                    //title name of the current page

     $f_script_name = $_SERVER["SCRIPT_NAME"];                            //current scripts path

     $f_html_wrapper = new HTML_Wrapper();

     $f_header = $f_html_wrapper->get_header();
     $f_html_output = $f_html_wrapper->get_homepage_page_error_form()['html_output'];
     $f_html_output2 = $f_html_wrapper->get_homepage_page_error_form()['html_output2'];

     $arr = [
       'landing_page' => $f_script_name,                                 //all values initialised are stored in this array and passed into
       'admin' => 'Hi there, ' . $f_admin,                                  //the render function along with the php file needed for render
       'header' => $f_header,
       'page_title' => $f_app_name,
       'html_output' => $f_html_output,
       'html_output2' => $f_html_output2,
     ];

     $app->render('display_homepage.php', $arr);
   }
 })->name('homepage_error');
