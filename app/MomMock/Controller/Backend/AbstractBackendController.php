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
 */

namespace MomMock\Controller\Backend;

use Silex\Application;
use Doctrine\DBAL\Connection;

/**
 * Class AbstractBackendController
 * @package MomMock\Controller\Backend
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class AbstractBackendController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * AbstractBackendController constructor.
     * @param Application $app
     */
    public function __construct(
        Application $app
    ){
        $this->app = $app;
    }

    /**
     * @return \Twig_Environment
     */
    protected function getTemplateEngine()
    {
        return $this->app['twig'];
    }

    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->app['db'];
    }
}