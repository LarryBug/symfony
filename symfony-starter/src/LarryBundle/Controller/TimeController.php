<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/24
 * Time: 4:55 PM
 */

namespace LarryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


date_default_timezone_set("PRC");

class TimeController extends Controller{
    /**
     * @Route("/time")
     */
    public function displayCurrentTimeAction(){


        $time = date("Y/m/d H:i:s A");

        $url = "https://www.baidu.com/s?wd=%E5%8C%97%E4%BA%AC%E6%97%B6%E9%97%B4";

        //return $this->redirectToRoute('homepage');
        //return New Response($time);
        return $this->render("larry/time.html.twig",array(
            "time" => $time,"url" => $url));
    }

}