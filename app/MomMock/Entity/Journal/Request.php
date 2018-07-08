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

namespace MomMock\Entity\Journal;

use MomMock\Entity\AbstractEntity;

/**
 * Class Item
 * @package MomMock\Entity\Journal
 * @author  Mahmood Dhia <m.dhia@techdivision.com>
 */
class Request extends AbstractEntity
{
    /**
     * Request status
     */
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_IGNORED = 'IGNORED';
    const STATUS_ERROR = 'ERROR';

    /**
     * Holds the table name
     */
    const TABLE_NAME = 'journal';

    /**
     * Holds the table columns
     * @var []
     */
    private $columns = [
        'id',
        'delivery_id',
        'status',
        'topic',
        'body',
        'sent_at',
        'retried_at',
        'tries',
        'direction',
        'to',
        'protocol'
    ];


    /**
     * @var []
     */
    private $data = [];

    /**
     * @param $key
     * @param $value
     * @return Request
     */
    public function setData($key, $value)
    {
        // if key is array override data array with it
        if(is_array($key)) {
            $this->data = $key;
        }

        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Saves an order item
     *
     * @return string
     */
    public function save()
    {
        $query = $this->db->createQueryBuilder()
            ->insert(self::TABLE_NAME);

        foreach ($this->columns as $column) {
            if (isset($this->data[$column])) {
                $query->setValue("`$column`", $this->db->quote($this->data[$column]));
            }
        }

        return $query->execute();
    }
}