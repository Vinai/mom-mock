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
use Doctrine\DBAL\Query\Expression\CompositeExpression;

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

        $order = $this->db->createQueryBuilder()
            ->select('*')
            ->from('`order`')
            ->where('`id` = ?')
            ->setParameter(0, $orderId)
            ->execute()
            ->fetch();

        $orComposite = new CompositeExpression(CompositeExpression::TYPE_OR);
        foreach ($orderItemIds as $orderItemId) {
            $orComposite->add('`id` = ' . $orderItemId);
        }

        $orderItems = $this->db->createQueryBuilder()
            ->select('*')
            ->from('`order_item`')
            ->where($orComposite)
            ->execute()
            ->fetchAll();

        // insert order data to shipment template
        $method = $this->methodResolver->getMethodForServiceClass(get_class($this));
        $template = $this->templateHelper->getTemplateForMethod($method);

        // insert order data
        foreach ($order as $key => $value) {
            $template = str_replace(sprintf('{{order.%s}}', $key), $value, $template);
        }

        // insert order item data
        $shipmentData = json_decode($template, true);

        $items = [];
        $aggregatedItems = [];
        $packageItems = [];

        foreach ($orderItems as $orderItem) {
            $itemTemplate = json_encode($shipmentData['shipment']['items'], true);
            $aggregatedItemTemplate = json_encode($shipmentData['shipment']['packages'][0]['aggregated_items'], true);
            $packageItemTemplate = json_encode($shipmentData['shipment']['packages'][0]['items'], true);

            foreach ($orderItem as $key => $value) {
                $itemTemplate = str_replace(sprintf('{{order_item.%s}}', $key), $value, $itemTemplate);
                $aggregatedItemTemplate = str_replace(sprintf('{{order_item.%s}}', $key), $value, $aggregatedItemTemplate);
                $packageItemTemplate = str_replace(sprintf('{{order_item.%s}}', $key), $value, $packageItemTemplate);
            }

            $items = array_merge($items, json_decode($itemTemplate, true));
            $aggregatedItems = array_merge($aggregatedItems, json_decode($aggregatedItemTemplate, true));
            $packageItems = array_merge($packageItems, json_decode($packageItemTemplate, true));
        }

        $shipmentData['shipment']['items'] = $items;
        $shipmentData['shipment']['packages'][0]['aggregated_items'] = $aggregatedItems;
        $shipmentData['shipment']['packages'][0]['items'] = $packageItems;

        return $this->rpcClient->send($shipmentData, $method);
    }
}