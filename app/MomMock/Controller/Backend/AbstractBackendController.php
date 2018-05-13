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

use Doctrine\DBAL\Connection;
use Slim\Container;

/**
 * Class AbstractBackendController
 * @package MomMock\Controller\Backend
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class AbstractBackendController
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var \Twig_Environment
     */
    private $templ;

    /**
     * AbstractBackendController constructor.
     * @param Container $container
     */
    public function __construct(
        Container $container
    ){
        $this->db = $container->get('db');
        $this->templ = $container->get('templ');
    }

    /**
     * @return \Twig_Environment
     */
    protected function getTemplateEngine()
    {
        return $this->templ;
    }

    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->db;
    }
}