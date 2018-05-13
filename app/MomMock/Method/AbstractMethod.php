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

namespace MomMock\Method;

use Doctrine\DBAL\Connection;

/**
 * Class AbstractMethod
 * @package MomMock\Method
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
abstract class AbstractMethod implements MethodInterface
{
    /**
     * Connection
     */
    protected $db;

    /**
     * @inheritdoc
     */
    public function setDb(Connection $db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDb()
    {
        return $this->db;
    }
}