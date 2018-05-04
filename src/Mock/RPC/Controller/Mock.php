<?php
namespace Mock\RPC\Controller;

use Symfony\Component\HttpFoundation\Request;

class Mock
{
    public function handle(Request $request)
    {
        error_log('Handle Webservice call...');
        $params = $request->getContent();
        return $params;
        //return json_encode($payload, JSON_UNESCAPED_SLASHES);
    }

    public function events(Request $request)
    {
        error_log('Handle Event call...');
    }

    public function remote(Request $request, $to)
    {
        error_log('Handle remote call...');
    }

    public function delegate(Request $request, $to)
    {
        error_log('Handle delegation...');
    }
}