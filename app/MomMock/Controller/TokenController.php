<?php

namespace MomMock\Controller;

use Symfony\Component\HttpFoundation\Response;

class TokenController
{
    public function indexAction()
    {
        return new Response(
            json_encode(['access_token' => 'token']),
            201
        );
    }
}