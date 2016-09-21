<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 16.05.16
 * Time: 18:52
 */

namespace ErmineApp\ResponseBundle\EventListener;

use ErmineApp\UserBundle\Service\RequestManager;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Response;

class YourExceptionListener
{
    /**
     * @var RequestManager
     */
    private $requestManager;

    /**
     * YourExceptionListener constructor.
     * @param RequestManager $requestManager
     */
    function __construct(RequestManager $requestManager)
    {
        $this->requestManager = $requestManager;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception =  $event->getException();
        if ($exception instanceof BadRequestHttpException) {
//            var_dump($exception->getMessage());die;

            $response2 = new Response(json_encode(['message' => 'options!']), 200);

            //create response, set status code etc.
            $response2->headers->set('X-Status-Code', 200);
            $event->setResponse($response2); //event will stop propagating here. Will not call other listeners.

//
//            /*Access denied */
//            if($exception->getMessage() == "No API key found"){
//                $response = new Response(json_encode(["errorCode" => "103", "success" => "0", 'message' => 'Access is denied!']), $this->getAgentCod());
//
//            /*Bad parameters*/
//            }elseif (True == !(strpos($exception->getMessage(), "Undefined required parameter") === False)){
//                $response = new Response(json_encode(["errorCode" => "400", "success" => "0", 'message' => $exception->getMessage()]), $this->getAgent());
//            }else{
//                $response = new Response(json_encode(["errorCode" => "400", "success" => "0", 'message' => $exception->getMessage()]), $this->getAgent());
//            }
//
//            $response->headers->set('X-Status-Code', $code);
//            $event->setResponse($response); //event will stop propagating here. Will not call other listeners.
        }
    }

    /**
     * @return string
     */
    public function getAgent(){
        $agent = $this->requestManager->user_agent();
        if($agent == 'ios'){
            $code = '200';
        }else{
            $code = '400';
        }
        return $code;
    }
}