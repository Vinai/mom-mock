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

namespace MomMock\Entity;

/**
 * Class Order
 * @package MomMock\Entity
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class Order extends AbstractEntity
{
    /**
     * Holds the table name
     */
    const TABLE_NAME = 'order';

    /**
     * @var string
     */
    private $incrementId;

    /**
     * @var string
     */
    private $store;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $statusReason;

    /**
     * @var string
     */
    private $originDate;

    /**
     * @param [] $data
     */
    public function setData(array $data)
    {
        $this->incrementId = $data['id'];
        $this->store = $data['store'];
        $this->status = $data['status'];
        $this->statusReason = $data['status_reason'];
        $this->originDate = $data['origin_date'];

        return $this;
    }

    /**
     * Saves an order
     *
     * @return string
     */
    public function save()
    {
        $this->db->createQueryBuilder()
            ->insert(sprintf("`%s`", self::TABLE_NAME))
            ->values([
                '`increment_id`' => "'{$this->incrementId}'",
                '`store`' => "'{$this->store}'",
                '`status`' => "'{$this->status}'",
                '`status_reason`' => "'{$this->statusReason}'",
                '`origin_date`' => "'{$this->originDate}'"
            ])
            ->execute();

        return $this->db->lastInsertId();
    }
}