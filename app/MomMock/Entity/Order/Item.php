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

namespace MomMock\Entity\Order;

use MomMock\Entity\AbstractEntity;

/**
 * Class Item
 * @package MomMock\Entity\Order
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class Item extends AbstractEntity
{
    /**
     * Holds the table name
     */
    const TABLE_NAME = 'order_item';

    /**
     * @var []
     */
    private $data;

    /**
     * @param [] $data
     */
    public function setData($orderId, array $data)
    {
        $this->data = $data;
        $this->data['order_id'] = $orderId;

        return $this;
    }

    /**
     * Saves an order item
     *
     * @return string
     */
    public function save()
    {
        $amount = json_encode($this->data['amount']);

        $this->db->createQueryBuilder()
            ->insert(sprintf("`%s`", self::TABLE_NAME))
            ->values([
                '`order_id`' => "'{$this->data['order_id']}'",
                '`id`' => "'{$this->data['id']}'",
                '`line_number`' => "'{$this->data['line_number']}'",
                '`product_type`' => "'{$this->data['product_type']}'",
                '`sku`' => "'{$this->data['sku']}'",
                '`product_name`' => "'{$this->data['product_name']}'",
                '`image_url`' => "'{$this->data['image_url']}'",
                '`order_line_price`' => "'{$amount}'"
            ])
            ->execute();

        return $this->db->lastInsertId();
    }
}