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
        $mock = $app["controllers_factory"];

        $mock->get("/", "Mock\\Controller\\Mock::index");

        $mock->post("/", "Mock\\Controller\\Mock::store");

        $mock->get("/{id}", "Mock\\Controller\\Mock::show");

        $mock->get("/edit/{id}", "Mock\\Controller\\Mock::edit");

        $mock->put("/{id}", "Mock\\Controller\\Mock::update");

        $mock->delete("/{id}", "Mock\\Controller\\Mock::destroy");

        return $mock;
    }
}