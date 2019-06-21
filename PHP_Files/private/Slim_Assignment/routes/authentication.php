<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * authentication.php
 *
 * This file initialises the settings used by the Slim array
 * and used for storing information on reoccuring information.
 * The reoccuring information is the information stored in the array which is used
 * for loading the appropriate contents within the HTML markup.
 *
 * It also renders the default index page, in this case the authentication page
 * for users to login and register with the EE client.
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;
require_once $f_wrapper_path . 'HTML_Wrapper.php';

$app->get('/', function() use ($app)
{

    $f_html_wrapper = new HTML_Wrapper();

    $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

    $f_app_name = 'EE Client';                                //title name of the current page

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_authentication_page_form();

    $arr = [                                                  //all values initialised are stored in this array and passed into
      'landing_page' => $f_script_name,                       //the render function along with the php file needed for render
      'header' => $f_header,
      'page_title' => $f_app_name,
      'html_output' => $f_html_output,
    ];

    $app->render('display_authenticationpage.php', $arr);
})->name('authentication');
