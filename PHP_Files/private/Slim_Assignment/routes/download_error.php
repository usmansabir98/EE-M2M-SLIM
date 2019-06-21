<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * download_error.php
 *
 * One of the files loaded by routes is download_error.php file.
 *
 * This file is responsible for displaying error when wrong number is inserted.
 *
 *
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_wrapper_path . 'HTML_Wrapper.php';

$app->get('/download_error', function() use ($app)
{
    if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
      return  $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
    }

    $f_script_name = $_SERVER["SCRIPT_NAME"];

    $f_app_name = 'EE Download Page';

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_download_error_page();

    $arr = [
        'landing_page' => $f_script_name,
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output,
    ];

    $app->render('display_error.php', $arr);

})->name('download_error');