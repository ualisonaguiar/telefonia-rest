<?php

//Debug
function x($arg)
{
	echo "<pre>";
	print_r($arg);
 echo "</pre>";
}

date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();

?>
