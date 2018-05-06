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

namespace MomMock\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 * @package MomMock\Controller\Backend
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class OrderController extends AbstractBackendController
{
    /**
     * Order list action
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $db = $this->getDb();

        $orders = $db->createQueryBuilder()
            ->select('*')
            ->from('`order`')
            ->execute()
            ->fetchAll();

        $tmplEngine = $this->getTemplateEngine();

        return new Response($tmplEngine->render(
            'order/list.twig',
            ['orders' => $orders]
        ));
    }

    /**
     * Order detail action
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function detailAction(Request $request, $id)
    {
        $db = $this->getDb();

        $order = $db->createQueryBuilder()
            ->select('*')
            ->from('`order`')
            ->where('`id` = ?')
            ->setParameter(0, $id)
            ->execute()
            ->fetch();

        $items = $db->createQueryBuilder()
            ->select('*')
            ->from('`order_item`')
            ->where('`order_id` = ?')
            ->setParameter(0, $id)
            ->execute()
            ->fetchAll();

        $tmplEngine = $this->getTemplateEngine();

        return new Response($tmplEngine->render(
            'order/detail.twig',
            [
                'order' => $order,
                'items' => $items
            ]
        ));
    }
}