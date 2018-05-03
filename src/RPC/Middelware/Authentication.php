<?php

namespace Mock\RPC\Middleware;

use Symfony\Component\HttpFoundation\Request;

class Authentication
{
    public function authenticate(Request $request, $app)
    {
        $auth = $request->headers->get("Authorization");
        $apikey = substr($auth, strpos($auth, ' '));
        $apikey = trim($apikey);
        $user = new User();

        $check = $user->authenticate($apikey);

        if (!$check) {
            $app->abort(401);
        } else {
            $request->attributes->set('userid', $check);
        }
    }
}