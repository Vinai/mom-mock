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
     * @var []
     */
    private $data;

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

        $this->db->createQueryBuilder()
            ->insert(self::TABLE_NAME)
            ->setValue('id', sprintf('"%s"', (isset($this->data['id']) ? $this->data['id'] : null)))
            ->setValue('delivery_id', sprintf('"%s"', $this->data['delivery_id']))
            ->setValue('status', sprintf('"%s"', $this->data['status']))
            ->setValue('topic', sprintf('"%s"', $this->data['topic']))
            ->setValue('body', sprintf('"%s"', $this->data['body']))
            ->setValue('sent_at', sprintf('"%s"', $this->data['sent_at']))
            ->setValue('retried_at', sprintf('"%s"', (isset($this->data['retried_at']) ? $this->data['retried_at'] : null)))
            ->setValue('tries', sprintf('"%s"', (isset($this->data['tries']) ? $this->data['tries'] : 0)))
            ->setValue('direction', sprintf('"%s"', $this->data['direction']))
            ->setValue('to', sprintf('"%s"', $this->data['to']))
            ->setValue('protocol', sprintf('"%s"', $this->data['protocol']))
            ->execute();

        return $this->db->lastInsertId();
    }
}