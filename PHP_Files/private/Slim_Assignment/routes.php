<?php

/**
 * Created by PhpStorm and Atom Editors.
 * Users: P14184295 and P14166609
 * Date: 20/11/2016
 *
 * routes.php
 *
 * Here the routes represents a route and a controller.
 * Class files are required appropriately in chronological order, the first required file will be loaded
 * to represent the authentication page.
 *
 * Any GET or POSTS made within the application will trigger the route files to retrieve the appropriate PHP
 * class files and represent data accordingly.
 */


require 'routes/authentication.php';
require 'routes/login.php';
require 'routes/register.php';
require 'routes/homepage.php';
require 'routes/process.php';
require 'routes/logout.php';
require 'routes/login_error.php';
require 'routes/register_error.php';
require 'routes/downloaddata.php';
require 'routes/displayinformation.php';
require 'routes/error.php';
require 'routes/display_error.php';
require 'routes/download_error.php';
