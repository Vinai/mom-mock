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

use Symfony\Component\HttpFoundation\Response;

/**
 * Class TokenController
 * @package MomMock\Controller
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class TokenController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return new Response(
            json_encode(['access_token' => 'token']),
            201
        );
    }
}