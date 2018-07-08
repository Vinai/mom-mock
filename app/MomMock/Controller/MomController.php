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

namespace MomMock\Controller;

use Slim\Container;
use MomMock\Helper\MethodResolver;
use MomMock\Entity\Journal\Request as JournalRequest;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Connection;

/**
 * Class MomController
 * @package MomMock\Controller
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class MomController
{
    /**
     * @var MethodResolver
     */
    private $methodResolver;

    /**
     * @var Connection
     */
    private $db;

    /**
     * MomController constructor.
     * @param Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(
        Container $container
    ){
        $this->methodResolver = $container->get('method_resolver');
        $this->db = $container->get('db');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     * @throws \Exception
     */
    public function indexAction(Request $request, Response $response)
    {
        $data = json_decode($request->getBody(), true);

        if (!array_key_exists('method', $data)
            || !in_array($data['method'], $this->methodResolver->getValidMethods()))
        {
            return $response->withJson(
                json_encode(['error_message' => 'No valid method provided']),
                404
            );
        }

        // log any incoming request in api journal
        $journal = new JournalRequest($this->db);
        $journal->setData('delivery_id', $data['id']);
        $journal->setData('status', JournalRequest::STATUS_SUCCESS); // placeholder @TODO check status after process
        $journal->setData('topic', $data['method']);
        $journal->setData('body', json_encode($data['params']));
        $journal->setData('sent_at', date('Y-m-d H:i:s'));
        $journal->setData('direction', 'incoming');
        $journal->setData('to', 'oms');
        $journal->setData('protocol', 'Service Bus (HTTP)');
        $journal->save();

        $responseData = $this->methodResolver
            ->getServiceClassForMethod($data['method'])
            ->setDb($this->db)
            ->handleRequestData($data);

        return $response->withJson($responseData);
    }
}