<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * display_error.php
 *
 * One of the files loaded by routes is display_error.php file.
 *
 * This file loads the view when the phone number inserted is not correct.
 *
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_wrapper_path . 'HTML_Wrapper.php';

$app->get('/display_error', function() use ($app)
{
    if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
      return  $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
    }

    $f_script_name = $_SERVER["SCRIPT_NAME"];

    $f_app_name = 'EE Review Page';

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_review_error_page();

    $arr = [
        'landing_page' => $f_script_name,
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output,
    ];

    $app->render('display_error.php', $arr);

})->name('display_error');