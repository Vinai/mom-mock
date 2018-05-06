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

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MomMock\Helper\MethodResolver;

/**
 * Class MomController
 * @package MomMock\Controller
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class MomController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var MethodResolver
     */
    private $methodResolver;

    /**
     * MomController constructor.
     * @param Application $app
     */
    public function __construct(
        Application $app
    ){
        $this->app = $app;
        $this->methodResolver = new MethodResolver();
    }

    /**
     * @param Request $request
     * @return string|Response
     */
    public function indexAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists('method', $data)
            || !in_array($data['method'], $this->methodResolver->getValidMethods()))
        {
            return new Response(
                json_encode(['error_message' => 'No valid method provided']),
                404
            );
        }

        $responseData = $this->methodResolver
            ->getServiceClassForMethod($data['method'])
            ->setApplication($this->app)
            ->handleRequestData($data);

        return json_encode($responseData);
    }
}