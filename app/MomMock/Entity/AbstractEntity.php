<?php

namespace MomMock\Entity;

use Doctrine\DBAL\Connection;

abstract class AbstractEntity
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * AbstractEntity constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
}