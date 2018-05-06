<?php

namespace MomMock\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MomMock\Helper\MethodResolver;

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

    public function __construct(
        Application $app
    ){
        $this->app = $app;
        $this->methodResolver = new MethodResolver();
    }

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