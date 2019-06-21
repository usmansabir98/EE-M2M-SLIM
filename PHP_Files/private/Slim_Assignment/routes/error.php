<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * error.php
 *
 * One of the files the route loads is this error.php file
 *
 * This file handles any global errors and renders it
 */

$f_wrapper_path = $app->config('wrappers.path') . DIRSEP;

require_once $f_wrapper_path . 'HTML_Wrapper.php';

$app->get('/error', function() use ($app)
{

        $f_app_name = 'EE Client - ERROR';                                    //title name of the current page

        $f_script_name = $_SERVER["SCRIPT_NAME"];                             //current scripts path

        $f_html_wrapper = new HTML_Wrapper();

        $f_header = $f_html_wrapper->get_header();
        $f_html_output = $f_html_wrapper->get_global_error_page();


    $arr = [                                                  //all values initialised are stored in this array and passed into
                                                              //the render function along with the php file needed for render
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output
    ];

        $app->render('display_global_error.php', $arr);

})->name('error');
