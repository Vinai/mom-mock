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

namespace MomMock\Method\Sales\OrderManagement;

use MomMock\Method\AbstractOutgoingMethod;

/**
 * Class Create
 * @package MomMock\Method\Sales\OrderManagement
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class Updated extends AbstractOutgoingMethod
{
    /**
     * @inheritdoc
     */
    public function send($data)
    {
        $orderId = $data['order_id'];

        $order = $this->db->createQueryBuilder()
            ->select('*')
            ->from('`order`')
            ->where('`id` = ?')
            ->setParameter(0, $orderId)
            ->execute()
            ->fetch();

        $orderItems = $this->db->createQueryBuilder()
            ->select('*')
            ->from('`order_item`')
            ->where('`order_id` = ?')
            ->setParameter(0, $orderId)
            ->execute()
            ->fetchAll();

        // insert order data to updated template
        $method = $this->methodResolver->getMethodForServiceClass(get_class($this));
        $template = $this->templateHelper->getTemplateForMethod($method);

        // insert order data
        foreach ($order as $key => $value) {
            $template = str_replace(sprintf('{{order.%s}}', $key), $value, $template);
        }

        // insert order item data
        $updatedData = json_decode($template, true);

        $items = [];
        $aggregatedItems = [];
        $packageItems = [];

        foreach ($orderItems as $orderItem) {
            $itemTemplate = json_encode($updatedData['shipment']['items'], true);
            $aggregatedItemTemplate = json_encode($updatedData['shipment']['packages'][0]['aggregated_items'], true);
            $packageItemTemplate = json_encode($updatedData['shipment']['packages'][0]['items'], true);

            foreach ($orderItem as $key => $value) {
                $itemTemplate = str_replace(sprintf('{{order_item.%s}}', $key), $value, $itemTemplate);
                $aggregatedItemTemplate = str_replace(sprintf('{{order_item.%s}}', $key), $value, $aggregatedItemTemplate);
                $packageItemTemplate = str_replace(sprintf('{{order_item.%s}}', $key), $value, $packageItemTemplate);
            }

            $items = array_merge($items, json_decode($itemTemplate, true));
            $aggregatedItems = array_merge($aggregatedItems, json_decode($aggregatedItemTemplate, true));
            $packageItems = array_merge($packageItems, json_decode($packageItemTemplate, true));
        }

        $updatedData['shipment']['items'] = $items;
        $updatedData['shipment']['packages'][0]['aggregated_items'] = $aggregatedItems;
        $updatedData['shipment']['packages'][0]['items'] = $packageItems;

        $result = $this->rpcClient->send($updatedData, $method);

        return $result;
    }
}