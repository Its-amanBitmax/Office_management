<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Project</title>
    
    <!-- Favicon -->
 <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKtsHBEsRHz3xCPHkhJDAA0d_-uzpLK7zab7T7qTk2drfyNOn6Bsghz35VHizHL3D4o7k&usqp=CAU" type="image/x-icon">

</head>
<body>
';

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
echo '</body></html>';