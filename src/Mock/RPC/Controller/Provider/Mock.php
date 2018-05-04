<?php

namespace Mock\RPC\Controller\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class Mock implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $factory = $app["controllers_factory"];
        $factory->post('/', 'Mock\RPC\Controller\Mock::handle');
        $factory->post('/events', 'Mock\RPC\Controller\Mock::events');
        $factory->post('/remote/{to}', 'Mock\RPC\Controller\Mock::remote');
        $factory->post('/delegate/{to}', 'Mock\RPC\Controller\Mock::delegate');

        return $factory;
    }
}