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

namespace MomMock\Method\Logistics\FulfillmentManagement;

use MomMock\Method\AbstractOutgoingMethod;

/**
 * Class CustomerShipmentDone
 * @package MomMock\Method\Logistics\FulfillmentManagement
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class CustomerShipmentDone extends AbstractOutgoingMethod
{
    /**
     * @inheritdoc
     */
    public function send($data)
    {
        $orderId = $data['order_id'];
        $orderItemIds = explode(',', $data['order_item_ids']);

        $orders = $this->db->createQueryBuilder()
            ->select('*')
            ->from('`order`')
            ->where('`id` = ?')
            ->setParameter(0, $orderId)
            ->execute()
            ->fetchAll();

        $orderItems = $this->db->createQueryBuilder()
            ->select('*')
            ->from('`order_item`')
            ->where('`id` IN (?)')
            ->setParameter(0, $orderItemIds)
            ->execute()
            ->fetchAll();

        $method = $this->methodResolver->getMethodForServiceClass(get_class($this));
    }
}