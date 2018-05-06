<?php

namespace MomMock\Method;

use Silex\Application;
use Doctrine\DBAL\Connection;

abstract class AbstractMethod implements MethodInterface
{
    /**
     * Application
     */
    protected $app;

    /**
     * @param Application $app
     * @return $this
     */
    public function setApplication(Application $app)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->app['db'];
    }
}