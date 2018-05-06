<?php
/**
 * Copyright (c) 2018 Magenerds
 * All rights reserved
 *
 * This product includes proprietary software developed at Magenerds, Germany
 * For more information see http://www.magenerds.com/
 *
 * To obtain a valid license for using this software please contact us at
 * info@magenerds.com
 *
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\AssetServiceProvider;
use MomMock\Controller\MomController;
use MomMock\Controller\TokenController;
use MomMock\Controller\Backend\OrderController;
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

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../app/templates',
]);

$app->register(new AssetServiceProvider(), [
    'assets.named_packages' => [
        'css' => ['base_path' => '']
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
$app['backend.order.controller'] = function() use ($app) {
    return new OrderController($app);
};

$app->post('/', 'mom.controller:indexAction');
$app->post('/delegate/oms', 'delegate.controller:indexAction');
$app->post('/oauth/token', 'token.controller:indexAction');
$app->get('/', 'backend.order.controller:listAction');
$app->get('/order/{id}', 'backend.order.controller:detailAction');

$app->run();