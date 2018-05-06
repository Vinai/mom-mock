<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use MomMock\Controller\MomController;
use MomMock\Controller\TokenController;
//use MomMock\Rpc\Middleware\Authentication as TodoAuth;

require __DIR__ . '/../vendor/autoload.php';
$app = new Application();

/*$app->before(function($request, $app) {
    TodoAuth::authenticate($request, $app);
});*/

$app->register(new ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider(), [
    'db.options' => [
        'driver' => 'pdo_mysql',
        'dbname' => 'mom',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'root'
    ],
]);

$app['mom.controller'] = function() use ($app) {
    return new MomController($app);
};
$app['delegate.controller'] = function() use ($app) {
    return new MomController($app);
};
$app['token.controller'] = function() use ($app) {
    return new TokenController();
};

$app->post('/', "mom.controller:indexAction");
$app->post('/delegate/oms', 'delegate.controller:indexAction');
$app->post('/oauth/token', 'token.controller:indexAction');

$app->run();