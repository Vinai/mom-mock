<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mock\RPC\Middleware\Authentication as TodoAuth;

include 'bootstrap.php';

require 'vendor/autoload.php';
$app = new Silex\Application();

/*$app->before(function($request, $app) {
    TodoAuth::authenticate($request, $app);
});*/

$app->get('simulate', new \Mock\RPC\Controller\Provider\Mock());

$app->run();