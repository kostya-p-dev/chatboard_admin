<?php

namespace ErmineApp\ResponseBundle\EventListener;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;


class RateLimitHeadersListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
//        var_dump($event->getResponse()->getContent() );die();

        $resp_content = json_decode($event->getResponse()->getContent());
//        var_dump($resp_content->error->exception[0]->message);die;
        if ($event->getResponse()->getStatusCode() == 400 and $resp_content->error->exception[0]->message == "Options") {

            $response2 = new Response(json_encode(["errorCode" => "100", "success" => "0", 'message' => 'options!']), 200);


            //create response, set status code etc.
            $response2->headers->set('X-Status-Code', 200);
            $event->setResponse($response2); //event will stop propagating here. Will not call other listeners.
//            return $event;
        }
//die('oo');
        $responseHeaders = $event->getResponse()->headers;

        // $responseHeaders->set('Access-Control-Allow-Headers', 'X-Requested-With');
        $responseHeaders->set('Access-Control-Allow-Credentials', 'true');
        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept, restToken');
        // $responseHeaders->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');


    }
}
