<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/23
 * Time: 9:02 PM
 */

namespace LarryBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener {

    public function onKernelRequest(GetResponseEvent $event){
        if(!$event->isMasterRequest()){
            //don't do anything if it's not the master request
           return;
        }

    }
}