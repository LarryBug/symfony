<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/23
 * Time: 8:44 PM
 */

namespace LarryBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class  ExceptionListener{
    public function onKernelException(GetResponseForExceptionEvent $event){
        //get the exception object from the received event
        $exception = $event->getException();
        $message = sprintf(
          $exception->getMessage(),
          $exception->getCode()
        );

        //Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);

        //HttpExceptionInterface is a special type of exception that holds status code and header details
        if($exception instanceof HttpExceptionInterface){
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }else{
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //sends the modified response object to the event
        $event->setResponse($response);
    }
}