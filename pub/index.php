<?php

use Mock\RPC\Controller\Provider\Mock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Mock\RPC\Middleware\Authentication as TodoAuth;

//include 'bootstrap.php';

require __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();

/*$app->before(function($request, $app) {
    TodoAuth::authenticate($request, $app);
});*/

$app->mount('/simulate', new Mock($app));

error_log('Get Webservice call...');
$app->run();