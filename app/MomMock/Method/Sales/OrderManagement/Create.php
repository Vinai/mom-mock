<?php

namespace MomMock\Method\Sales\OrderManagement;

use MomMock\Method\AbstractMethod;
use MomMock\Entity\Order;
use MomMock\Entity\Order\Item;

class Create extends AbstractMethod
{
    /**
     * @inheritdoc
     */
    public function handleRequestData($data)
    {
        if (!isset($data['params']) || !isset($data['params']['order'])) {
            throw new \Exception('No order data was given');
        }

        $order = $data['params']['order'];

        $orderId = $this->createOrder($order);

        foreach ($order['lines'] as $line) {
            $this->createOrderItem($orderId, $line);
        }

        return [];
    }

    /**
     * @param $order
     * @return string
     */
    protected function createOrder($orderData)
    {
        $order = new Order($this->getDb());
        return $order->setData($orderData)->save();
    }

    /**
     * @param $orderId
     * @param $itemData
     * @return string
     */
    protected function createOrderItem($orderId, $itemData)
    {
        $item = new Item($this->getDb());
        return $item->setData($orderId, $itemData)->save();
    }
}