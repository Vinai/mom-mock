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
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $lineNumber;

    /**
     * @var string
     */
    private $productType;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $json;

    /**
     * @param [] $data
     */
    public function setData($orderId, array $data)
    {
        $this->orderId = $orderId;
        $this->id = $data['id'];
        $this->lineNumber = $data['line_number'];
        $this->productType = $data['product_type'];
        $this->sku = $data['sku'];
        $this->productName = $data['product_name'];
        $this->imageUrl = $data['image_url'];
        $this->json = json_encode($data);

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
            ->insert(sprintf("`%s`", self::TABLE_NAME))
            ->values([
                '`order_id`' => "'{$this->orderId}'",
                '`id`' => "'{$this->id}'",
                '`line_number`' => "'{$this->lineNumber}'",
                '`product_type`' => "'{$this->productType}'",
                '`sku`' => "'{$this->sku}'",
                '`product_name`' => "'{$this->productName}'",
                '`image_url`' => "'{$this->imageUrl}'",
                '`json`' => "'{$this->json}'"
            ])
            ->execute();

        return $this->db->lastInsertId();
    }
}