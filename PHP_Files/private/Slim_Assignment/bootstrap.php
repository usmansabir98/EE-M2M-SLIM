<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * bootstrap.php
 *
 * Here the call to routes is made as well as storing information of the Class paths.
 * Slim application is also started on this file hence the name bootstrap because it is
 * a starting file to all other Class files to run the application.
 */

session_start();	//starts a slim session

require_once 'PHP_Files/private/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

define ('DIRSEP', DIRECTORY_SEPARATOR);

/*
 * Configuration is done by calling the Slim function and passing it some values that are used
 * later on in the application.
 */
$app = new \Slim\Slim(array(
	'mode' => 'production',
	'debug' => false,

	//Paths to the different class files
	'app_route.path' => __DIR__,
	'templates.path' => __DIR__ . '/view_templates',
	'classes.path'	=>	__DIR__ . '/classes',
	'wrappers.path'	=>	__DIR__ . '/wrappers'
));

require 'routes.php';

$app->run();




